<?php

namespace api\services;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use api\models\Order;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

final class OrderStripePayment
{
    public static function getSecret(): string
    {
        return trim((string) (Yii::$app->params['stripe.secretKey'] ?? ''));
    }

    public static function requireStripe(): StripeClient
    {
        $secret = self::getSecret();
        if ($secret === '') {
            throw new BadRequestHttpException(
                'Card payments are not configured. Add stripe.secretKey to backend/api/config/params-local.php.'
            );
        }

        return new StripeClient($secret);
    }

    /**
     * @param list<int> $orderIds
     * @return array{clientSecret: string, paymentIntentId: string, amountPence: int, currency: string, orderIds: list<int>}
     */
    public static function createOrResumePaymentIntent(int $customerId, array $orderIds): array
    {
        $orderIds = array_values(array_unique(array_map('intval', $orderIds)));
        $orderIds = array_values(array_filter($orderIds, static fn (int $id) => $id > 0));
        if ($orderIds === []) {
            throw new BadRequestHttpException('order_ids must be a non-empty array of order ids.');
        }

        /** @var Order[] $orders */
        $orders = Order::find()
            ->where(['id' => $orderIds, 'customer_id' => $customerId])
            ->orderBy(['id' => SORT_ASC])
            ->all();

        if (count($orders) !== count($orderIds)) {
            throw new NotFoundHttpException('One or more orders were not found.');
        }

        foreach ($orders as $order) {
            if ($order->status !== Order::STATUS_PENDING_PAYMENT) {
                throw new BadRequestHttpException('Only orders that are pending payment can be paid.');
            }
        }

        $piIds = array_values(array_unique(array_filter(
            array_map(static fn (Order $o) => trim((string) ($o->stripe_payment_intent_id ?? '')), $orders)
        )));
        if (count($piIds) > 1) {
            throw new BadRequestHttpException('These orders are linked to different payment sessions. Contact support.');
        }

        $totalPence = 0;
        foreach ($orders as $order) {
            $totalPence += (int) round(round((float) $order->price_total, 2) * 100);
        }

        if ($totalPence < 30) {
            throw new BadRequestHttpException('Order total is below the minimum card charge (30 pence).');
        }

        $stripe = self::requireStripe();

        if (count($piIds) === 1 && $piIds[0] !== '') {
            try {
                /** @var PaymentIntent $pi */
                $pi = $stripe->paymentIntents->retrieve($piIds[0]);
                if ($pi->status === 'succeeded') {
                    throw new BadRequestHttpException('This checkout was already paid.');
                }
                if (
                    in_array($pi->status, ['requires_payment_method', 'requires_confirmation', 'requires_action', 'processing'], true)
                    && $pi->client_secret
                ) {
                    $metaOrderIds = self::parseOrderIdsFromMetadata($pi->metadata['order_ids'] ?? '');
                    $metaCustomer = (int) ($pi->metadata['customer_id'] ?? 0);
                    sort($metaOrderIds);
                    $sorted = $orderIds;
                    sort($sorted);
                    if ($metaCustomer === $customerId && $metaOrderIds === $sorted) {
                        return [
                            'clientSecret' => $pi->client_secret,
                            'paymentIntentId' => $pi->id,
                            'amountPence' => (int) $pi->amount,
                            'currency' => (string) $pi->currency,
                            'orderIds' => $orderIds,
                        ];
                    }
                }
            } catch (ApiErrorException $e) {
                Yii::warning('Could not resume PaymentIntent: ' . $e->getMessage(), __METHOD__);
            }
        }

        $pi = $stripe->paymentIntents->create([
            'amount' => $totalPence,
            'currency' => 'gbp',
            'automatic_payment_methods' => ['enabled' => true],
            'metadata' => [
                'customer_id' => (string) $customerId,
                'order_ids' => implode(',', $orderIds),
            ],
        ]);

        foreach ($orders as $order) {
            $order->stripe_payment_intent_id = $pi->id;
            if (!$order->save(false, ['stripe_payment_intent_id'])) {
                throw new BadRequestHttpException('Could not link payment session to orders.');
            }
        }

        return [
            'clientSecret' => $pi->client_secret,
            'paymentIntentId' => $pi->id,
            'amountPence' => $totalPence,
            'currency' => 'gbp',
            'orderIds' => $orderIds,
        ];
    }

    public static function syncPaidFromIntentForCustomer(int $customerId, string $paymentIntentId): void
    {
        $stripe = self::requireStripe();
        try {
            /** @var PaymentIntent $pi */
            $pi = $stripe->paymentIntents->retrieve($paymentIntentId);
        } catch (ApiErrorException $e) {
            throw new BadRequestHttpException('Could not load payment from Stripe.');
        }

        if ($pi->status !== 'succeeded') {
            throw new BadRequestHttpException('Payment has not completed yet.');
        }

        if ((int) ($pi->metadata['customer_id'] ?? 0) !== $customerId) {
            throw new ForbiddenHttpException('This payment does not belong to your account.');
        }

        $ids = self::parseOrderIdsFromMetadata($pi->metadata['order_ids'] ?? '');
        if ($ids === []) {
            throw new BadRequestHttpException('Invalid payment metadata.');
        }

        self::markOrdersPaid($customerId, $ids);
    }

    public static function handleWebhookPaymentIntentSucceeded(PaymentIntent $pi): void
    {
        if ($pi->status !== 'succeeded') {
            return;
        }

        $customerId = (int) ($pi->metadata['customer_id'] ?? 0);
        $ids = self::parseOrderIdsFromMetadata($pi->metadata['order_ids'] ?? '');
        if ($customerId <= 0 || $ids === []) {
            Yii::warning('payment_intent.succeeded missing customer_id or order_ids: ' . $pi->id, __METHOD__);
            return;
        }

        self::markOrdersPaid($customerId, $ids);
    }

    /**
     * @param list<int> $orderIds
     */
    private static function markOrdersPaid(int $customerId, array $orderIds): void
    {
        $db = Yii::$app->db;
        $db->transaction(static function () use ($customerId, $orderIds) {
            /** @var Order[] $orders */
            $orders = Order::find()
                ->where(['id' => $orderIds, 'customer_id' => $customerId])
                ->all();

            foreach ($orders as $order) {
                if ($order->status !== Order::STATUS_PENDING_PAYMENT) {
                    continue;
                }
                $order->status = Order::STATUS_PAID;
                if (!$order->save()) {
                    throw new BadRequestHttpException(json_encode($order->errors));
                }
            }
        });
    }

    /**
     * @return list<int>
     */
    private static function parseOrderIdsFromMetadata(mixed $raw): array
    {
        $s = trim((string) $raw);
        if ($s === '') {
            return [];
        }

        $parts = preg_split('/\s*,\s*/', $s) ?: [];
        $out = [];
        foreach ($parts as $p) {
            $id = (int) $p;
            if ($id > 0) {
                $out[] = $id;
            }
        }

        return array_values(array_unique($out));
    }
}

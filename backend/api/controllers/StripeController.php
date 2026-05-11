<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use api\services\OrderStripePayment;
use Stripe\PaymentIntent;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        return $behaviors;
    }

    public function actionOptions()
    {
        return ['ok' => true];
    }

    /**
     * Stripe webhooks (no auth). Configure endpoint in Dashboard → Developers → Webhooks.
     * Requires stripe.webhookSecret in params-local.php.
     */
    public function actionWebhook()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $webhookSecret = trim((string) (Yii::$app->params['stripe.webhookSecret'] ?? ''));
        if ($webhookSecret === '') {
            Yii::$app->response->statusCode = 503;
            return ['received' => false, 'error' => 'Webhook signing secret is not configured.'];
        }

        $payload = Yii::$app->request->getRawBody();
        $sigHeader = (string) Yii::$app->request->headers->get('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Stripe\Exception\UnexpectedValueException $e) {
            throw new BadRequestHttpException('Invalid webhook payload.');
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            throw new BadRequestHttpException('Invalid webhook signature.');
        }

        if ($event->type === 'payment_intent.succeeded') {
            /** @var PaymentIntent $pi */
            $pi = $event->data->object;
            OrderStripePayment::handleWebhookPaymentIntentSucceeded($pi);
        }

        return ['received' => true];
    }
}

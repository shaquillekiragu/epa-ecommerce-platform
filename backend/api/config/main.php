<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
            'modules' => [
                'auth' => ['class' => 'api\modules\v1\auth\Module'],
                'customer' => ['class' => 'api\modules\v1\customer\Module'],
                'merchant' => ['class' => 'api\modules\v1\merchant\Module'],
            ],
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            // Storefront API is bearer-token only; do not restore identity from session cookie.
            'enableAutoLogin' => false,
            'loginUrl' => null,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'session-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                // CORS preflight
                'OPTIONS api/v1/<path:.+>' => 'auth/options',
                
                // Auth
                'POST api/v1/auth/register' => 'auth/register',
                'POST api/v1/auth/login' => 'auth/login',
                'POST api/v1/auth/logout' => 'auth/logout',
                'POST api/v1/stripe/webhook' => 'stripe/webhook',

                // Public catalogue convenience aliases
                'GET api/v1/products' => 'product/index',
                'GET api/v1/products/<id:\\d+>' => 'product/view',
                'GET api/v1/categories' => 'productcategory/index',

                // Customer (bearer token + role=customer)
                'GET api/v1/user' => 'customer/user', // Authenticated customer's profile (customer role).
                'GET api/v1/me' => 'me/index', // Lightweight "who am I" for any authenticated user.
                'GET api/v1/basket' => 'customer/basket', // Current basket with line items.
                'POST api/v1/basket/add' => 'customer/basket-add', // Add a product line to the basket.
                'PATCH api/v1/basket/item/<id:\\d+>' => 'customer/basket-item', // Set line qty or remove line (id = product id).
                'POST api/v1/checkout' => 'customer/checkout', // Turn basket into pending orders for an address.
                'POST api/v1/customer/payments/create-intent' => 'customer/create-payment-intent', // Stripe PaymentIntent for pending orders.
                'POST api/v1/customer/payments/sync' => 'customer/sync-payment', // Mark orders paid from a succeeded intent (client-side sync).
                'POST api/v1/customer/orders/<id:\\d+>/cancel' => 'customer/order-cancel', // Cancel a pending order (refund if already paid).
                'GET api/v1/customer/orders/<id:\\d+>' => 'customer/order-view', // Single order detail for the customer.
                'GET api/v1/customer/orders' => 'customer/orders', // List the customer's orders.
                'POST api/v1/customer/addresses' => 'customer/addresses-create', // Save a new delivery address.
                'GET api/v1/customer/addresses' => 'customer/addresses', // List saved addresses.

                // Merchant (bearer token + role=merchant + store ownership)
                'GET api/v1/merchant/store' => 'merchant/store', // Single store by id (must belong to merchant).
                'GET api/v1/merchant/stores' => 'merchant/stores', // List all stores for this merchant.
                'POST api/v1/merchant/stores' => 'merchant/stores-create', // Create a new store.
                'PATCH api/v1/merchant/stores/<id:\\d+>' => 'merchant/stores-update', // Update store name/description.
                'DELETE api/v1/merchant/stores/<id:\\d+>' => 'merchant/stores-delete', // Delete an empty store (no products/orders).
                'GET api/v1/merchant/orders' => 'merchant/orders', // Orders for one store (?store=id).
                'GET api/v1/merchant/orders-all' => 'merchant/orders-all', // Orders across all merchant stores.
                'GET api/v1/merchant/orders/<id:\\d+>' => 'merchant/order-view', // Single order with line items.
                'PATCH api/v1/merchant/orders/<id:\\d+>/status' => 'merchant/order-status', // Mark a paid order as shipped.
                'GET api/v1/merchant/products' => 'merchant/products-list', // Products for one store (?store=id).
                'POST api/v1/merchant/products' => 'merchant/products', // Create a product in a store.
                'GET api/v1/merchant/products/<id:\\d+>' => 'merchant/product-view', // Single product (merchant's store).
                'PATCH api/v1/merchant/products/<id:\\d+>' => 'merchant/product-update', // Update product fields.
                'DELETE api/v1/merchant/products/<id:\\d+>' => 'merchant/product-delete', // Remove a product from the store.

                // Only public catalogue/store discovery via REST. Sensitive models are exposed via
                // scoped customer/* and merchant/* routes with role checks — not generic ActiveController lists.
                [
                    'class' => \yii\rest\UrlRule::class,
                    'prefix' => 'api/v1',
                    'controller' => [
                        'product',
                        'productcategory',
                        'store',
                    ],
                    'pluralize' => true,
                ],
            ],
        ],
    ],
    'params' => $params,
];

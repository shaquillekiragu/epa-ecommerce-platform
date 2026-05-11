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
                'GET api/v1/user' => 'customer/user',
                'GET api/v1/me' => 'me/index',
                'GET api/v1/basket' => 'customer/basket',
                'POST api/v1/basket/add' => 'customer/basket-add',
                'PATCH api/v1/basket/item/<id:\\d+>' => 'customer/basket-item',
                'POST api/v1/checkout' => 'customer/checkout',
                'POST api/v1/customer/payments/create-intent' => 'customer/create-payment-intent',
                'POST api/v1/customer/payments/sync' => 'customer/sync-payment',
                'POST api/v1/customer/orders/<id:\\d+>/cancel' => 'customer/order-cancel',
                'GET api/v1/customer/orders/<id:\\d+>' => 'customer/order-view',
                'GET api/v1/customer/orders' => 'customer/orders',
                'POST api/v1/customer/addresses' => 'customer/addresses-create',
                'GET api/v1/customer/addresses' => 'customer/addresses',

                // Merchant (bearer token + role=merchant + store ownership)
                'GET api/v1/merchant/store' => 'merchant/store',
                'GET api/v1/merchant/orders' => 'merchant/orders',
                'PATCH api/v1/merchant/orders/<id:\\d+>/status' => 'merchant/order-status',
                'POST api/v1/merchant/products' => 'merchant/products',
                'DELETE api/v1/merchant/products/<id:\\d+>' => 'merchant/delete-product',

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

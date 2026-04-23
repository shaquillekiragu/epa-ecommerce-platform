<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'superadmin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'superadmin\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'defaultRoute' => '/dashboard',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-superadmin',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-superadmin', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the superadmin
            'name' => 'session-superadmin',
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
                // '' => 'dashboard/index',
                'user' => 'user/index',
                'order' => 'order/index',
                'product' => 'product/index',
                'product-category' => 'productcategory/index',
                'store' => 'store/index',
                'basket' => 'basket/index',
                'address' => 'address/index',
                'orderproduct' => 'orderproduct/index',
                'basketproduct' => 'basketproduct/index',
                'useraddress' => 'useraddress/index',
            ],
        ],
    ],
    'params' => $params,
];

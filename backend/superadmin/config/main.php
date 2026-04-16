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
                '' => 'site/index',
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'address'],
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'basket'],
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'basketproduct'],
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'order'],
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'orderproduct'],
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'product'],
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'productcategory'],
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'store'],
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'user'],
                ['class' => \yii\rest\UrlRule::class, 'controller' => 'useraddress'],
            ],
        ],
    ],
    'params' => $params,
];

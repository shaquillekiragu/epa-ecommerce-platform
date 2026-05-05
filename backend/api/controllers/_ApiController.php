<?php

namespace api\controllers;

use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\Cors;

class _ApiController extends ActiveController
{
    /**
     * Common REST API behaviours (JSON + CORS).
     *
     * Concrete controllers should set `public $modelClass = Foo::class;`
     * and may override this to add authentication/authorization.
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        // Auth placeholder: enable when you implement bearer tokens/JWT.
        // $behaviors['authenticator'] = [
        //     'class' => \yii\filters\auth\HttpBearerAuth::class,
        // ];

        return $behaviors;
    }
}

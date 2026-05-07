<?php

namespace api\controllers;

use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\Cors;
use yii\web\ForbiddenHttpException;

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
        // Concrete controllers can set `$this->authRequired = true` and/or enforce roles.
        if (property_exists($this, 'authRequired') && $this->authRequired) {
            $behaviors['authenticator'] = [
                'class' => \api\components\BearerTokenAuth::class,
            ];
        }

        return $behaviors;
    }

    protected function requireRole(string $role): void
    {
        $identity = \Yii::$app->user->identity;
        
        if ($identity === null || ($identity->role ?? null) !== $role) {
            throw new ForbiddenHttpException('Forbidden.');
        }
    }
}

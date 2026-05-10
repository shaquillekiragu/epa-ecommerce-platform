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

        // Ensure CORS runs even when authentication fails.
        // Yii's REST controllers may register an authenticator in parent::behaviors(),
        // so we remove it and re-add after the CORS filter below.
        if (isset($behaviors['authenticator'])) {
            unset($behaviors['authenticator']);
        }

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

        // Auth: enable per-controller with `$auth_required = true`.
        // Backwards compatible with older `$authRequired` while we migrate.
        $auth_required = false;
        
        if (property_exists($this, 'auth_required')) {
            $auth_required = (bool)$this->auth_required;
        } elseif (property_exists($this, 'authRequired')) {
            $auth_required = (bool)$this->authRequired;
        }

        if ($auth_required) {
            $behaviors['authenticator'] = [
                'class' => \api\components\BearerTokenAuth::class,
                'except' => ['options'],
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

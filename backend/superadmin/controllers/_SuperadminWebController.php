<?php

namespace superadmin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class _SuperadminWebController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => [$this, 'handleUnauthorisedUser'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => static function (): bool {
                            $identity = Yii::$app->user->identity;
                            return $identity !== null && ($identity->role ?? null) === 'superadmin';
                        },
                    ],
                ],
            ],
        ];
    }

    public function handleUnauthorisedUser()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->response->redirect(['site/login']);
        }
        throw new ForbiddenHttpException('You do not have permission to access this area.');
    }
}

<?php

namespace superadmin\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use yii\web\HttpException;

class _SuperadminController extends ActiveController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'view',
                            'create',
                            'update',
                            'delete',
                        ],
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest && !$this>checkAdminAccess()) {
            $this->redirectNonAdminUser();
        }
        return parent::beforeAction($action);
    }
}

// research yii's in-built role functionality - auth item, assignment - allows you to define roles - ranked roles

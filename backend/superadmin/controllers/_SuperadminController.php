<?php

namespace superadmin\controllers;

use yii\rest\ActiveController;
use yii\filters\AccessControl;

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
}

// research yii's in-built role functionality - auth item, assignment - allows you to define roles - ranked roles

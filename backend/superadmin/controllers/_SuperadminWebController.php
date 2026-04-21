<?php

namespace superadmin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class _SuperadminWebController extends Controller
{
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'denyCallback' => [$this, 'handleUnauthorisedUser'],
    //             'rules' => [
    //                 // [
    //                 //     'actions' => [
    //                 //         'index',
    //                 //         'view',
    //                 //         'create',
    //                 //         'update',
    //                 //         'delete',
    //                 //     ],
    //                 //     'allow' => true,
    //                 //     'roles' => ['superadmin'],
    //                 // ],
    //                 [
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                     'matchCallback' => fn () => Yii::$app->user->can('superadmin'),
    //                 ],
    //             ],
    //         ],
    //     ];
    // }

    public function handleUnauthorisedUser()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->response->redirect(['site/login']);
        }
        throw new ForbiddenHttpException('Superadmin access required.');
    }
}

// research yii's in-built role functionality - auth item, assignment - allows you to define roles - ranked roles
// disable rbac for now - until you ensure admin views are visable
<?php

namespace api\controllers;

use yii\web\UnauthorizedHttpException;
use api\models\User;

class MeController extends _ApiController
{
    public $auth_required = true;
    public $modelClass = User::class;

    public function actions()
    {
        return [];
    }

    public function actionIndex()
    {
        /** @var \common\models\User|null $identity */
        $identity = \Yii::$app->user->identity;

        if ($identity === null) {
            throw new UnauthorizedHttpException('Not authenticated.');
        }

        return User::findOne((int)$identity->id) ?? $identity;
    }
}

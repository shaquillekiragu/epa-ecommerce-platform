<?php

namespace superadmin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => static function () {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->response->redirect(['site/login']);
                    }

                    throw new \yii\web\ForbiddenHttpException('You do not have permission to access this area.');
                },
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => static function (): bool {
                            $identity = Yii::$app->user->identity;
                            return $identity !== null && ($identity->role ?? null) === 'superadmin';
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $identity = Yii::$app->user->identity;

            if ($identity !== null && ($identity->role ?? null) === 'superadmin') {
                return $this->goHome();
            }
            
            Yii::$app->user->logout();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $identity = Yii::$app->user->identity;
            
            if ($identity === null || ($identity->role ?? null) !== 'superadmin') {
                Yii::$app->user->logout();
                $model->addError('password', 'You do not have permission to access this area.');

                return $this->render('login', [
                    'model' => $model,
                ]);
            }

            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}

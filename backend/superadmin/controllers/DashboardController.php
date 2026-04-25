<?php

namespace superadmin\controllers;

use yii\data\ActiveDataProvider;
use yii\helpers\Inflector;
use superadmin\models\User;

class DashboardController extends _SuperadminWebController
{
    public $model_class;
    public $search_model_class;

	public function actionIndex()
    {
        $model_class = $this->model_class ?? User::class;
        $plural_label = Inflector::pluralize(Inflector::camel2words((new \ReflectionClass($model_class))->getShortName()));

        $this->view->params['breadcrumbs'] = [
            $plural_label,
        ];

        $data_provider = new ActiveDataProvider([
            'query' => $model_class::find(),
            'pagination' => ['pageSize' => 50],
        ]);

        try {
            return $this->render('index', [
                'data_provider' => $data_provider,
                'model_class' => $model_class,
            ]);
            //
        } catch (\Throwable $th) {
            return $this->render('@superadmin/views/_shared/index', [
                'data_provider' => $data_provider,
                'model_class' => $model_class,
            ]);
        }
    }

    public function actionView($id)
    {
        $model_class = $this->model_class ?? User::class;
        $plural_label = Inflector::pluralize(Inflector::camel2words((new \ReflectionClass($model_class))->getShortName()));

        $primary_key = $model_class::primaryKey()[0] ?? 'id';
        $model = $model_class::findOne([$primary_key => (int) $id]);
        
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Record not found.');
        }

        $this->view->params['breadcrumbs'] = [
            ['label' => $plural_label, 'url' => ['index']],
            'View > ' . $model->id,
        ];
        
        $data_provider = new ActiveDataProvider([
            'query' => $model_class::find()->where([$primary_key => (int) $id]),
            'pagination' => ['pageSize' => 50],
        ]);

        try {
            return $this->render('view', [
                'data_provider' => $data_provider,
                'model' => $model,
                'model_class' => $model_class,
            ]);
            //
        } catch (\Throwable $th) {
            return $this->render('@superadmin/views/_shared/view', [
                'data_provider' => $data_provider,
                'model' => $model,
                'model_class' => $model_class,
            ]);
        }
    }

    public function actionCreate()
    {
        
    }

    public function actionUpdate($id)
    {
        
    }

    public function actionDelete($id)
    {
        
    }
}

// consider separating/overriding crud view
// create markdown files breaking down plans and steps

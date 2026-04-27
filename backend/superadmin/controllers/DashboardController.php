<?php

namespace superadmin\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use superadmin\models\User;

class DashboardController extends _SuperadminWebController
{
    public $model_class;
    public $search_model_class;

	public function actionIndex()
    {
        $model_class = $this->model_class ?? User::class;
        $plural_label = Inflector::pluralize(Inflector::camel2words((new \ReflectionClass($model_class))->getShortName()));

        $this->view->params['breadcrumbs'][] = $plural_label;

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
        $short_name = (new \ReflectionClass($model_class))->getShortName();
        $plural_label = Inflector::pluralize(Inflector::camel2words($short_name));
        $singular_url = '/' . Inflector::camel2id($short_name);

        $primary_key = $model_class::primaryKey()[0] ?? 'id';
        $model = $model_class::findOne([$primary_key => (int) $id]);
        
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Record not found.');
        }

        $this->view->params['breadcrumbs'][] = ['label' => $plural_label, 'url' => $singular_url];
        $this->view->params['breadcrumbs'][] = 'View > ' . $model->id;
        
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
        // new Model()
        // handle validation of data on user submission, then redirect
        // then redirect to the rendered the view
        // if the user clicks submit and validation fails, show red fields in the same form view - check if Yii does this
    }

    public function actionUpdate($id)
    {
        // is it a POST request? then load
        // find the model
        // handle validation of data on user submission
        // then redirect to the rendered the view
        // if the user clicks submit and validation fails, show red fields in the same form view - check if Yii does this
    }

    public function actionDelete($id)
    {
        if (!Yii::$app->request->isPost) {
            throw new MethodNotAllowedHttpException('Delete must be a POST request.');
        }

        $model_class = $this->model_class ?? User::class;
        $primary_key = $model_class::primaryKey()[0] ?? 'id';

        $model = $model_class::findOne([$primary_key => (int) $id]);

        if (!$model) {
            throw new NotFoundHttpException('Record not found.');
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Record deleted.');

        return $this->redirect(['index']);

        // add a Yii confirmation popup
        // add SQL functionality (ON CASCADE)
        // keep this here, override if necessary in spcecifc controllers
    }
}

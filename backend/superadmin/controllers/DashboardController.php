<?php

namespace superadmin\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\ForbiddenHttpException;
use superadmin\models\User;
use superadmin\models\Basketproduct;
use superadmin\models\Orderproduct;
use superadmin\models\Useraddress;

class DashboardController extends _SuperadminWebController
{
    public $model_class;
    public $filter_model_class;

	public function actionIndex()
    {
        $model_class = $this->model_class ?? User::class;
        $filter_model_class = $this->filter_model_class ?? null;
        
        $plural_label = Inflector::pluralize(Inflector::camel2words((new \ReflectionClass($model_class))->getShortName()));

        $this->view->params['breadcrumbs'][] = $plural_label;

        $filter_model = null;

        if ($filter_model_class) {
            $filter_model = new $filter_model_class();
            $data_provider = $filter_model->search(Yii::$app->request->queryParams);
            //
        } else {
            $data_provider = new ActiveDataProvider([
                'query' => $model_class::find(),
                'pagination' => ['pageSize' => 50],
            ]);
        }

        try {
            return $this->render('index', [
                'data_provider' => $data_provider,
                'model_class' => $model_class,
                'filter_model' => $filter_model,
            ]);
            //
        } catch (\Throwable $th) {
            return $this->render('@superadmin/views/_shared/index', [
                'data_provider' => $data_provider,
                'model_class' => $model_class,
                'filter_model' => $filter_model,
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
            throw new NotFoundHttpException('Record not found.');
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
        $model_class = $this->model_class ?? User::class;
        $no_creation = $model_class === Basketproduct::class || $model_class === Orderproduct::class || $model_class === Useraddress::class;

        if ($no_creation) {
            throw new ForbiddenHttpException('Data creation is not allowed for this table.');
        }

        $short_name = (new \ReflectionClass($model_class))->getShortName();
        $plural_label = Inflector::pluralize(Inflector::camel2words($short_name));
        $singular_url = '/' . Inflector::camel2id($short_name);

        $model = new $model_class();

        $this->view->params['breadcrumbs'][] = ['label' => $plural_label, 'url' => $singular_url];
        $this->view->params['breadcrumbs'][] = 'Create';

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Record created.');
            return $this->redirect(['view', 'id' => $model->getPrimaryKey()]);
        }

        return $this->render('@superadmin/views/_shared/create', [
            'model' => $model,
            'model_class' => $model_class,
        ]);
    }

    public function actionUpdate($id)
    {
        $model_class = $this->model_class ?? User::class;

        $short_name = (new \ReflectionClass($model_class))->getShortName();
        $plural_label = Inflector::pluralize(Inflector::camel2words($short_name));
        $singular_url = '/' . Inflector::camel2id($short_name);

        $primary_key = $model_class::primaryKey()[0] ?? 'id';
        $model = $model_class::findOne([$primary_key => (int) $id]);
        
        if (!$model) {
            throw new NotFoundHttpException('Record not found.');
        }

        if ($model->hasAttribute('allow_update') && $model->allow_update === false) {
            throw new ForbiddenHttpException('Updating is not allowed for this record.');
        }

        $this->view->params['breadcrumbs'][] = ['label' => $plural_label, 'url' => $singular_url];
        $this->view->params['breadcrumbs'][] = 'Update > ' . $model->id;

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Record updated.');
            return $this->redirect(['view', 'id' => $model->getPrimaryKey()]);
        }

        return $this->render('@superadmin/views/_shared/update', [
            'model' => $model,
            'model_class' => $model_class,
        ]);
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

        if ($model->hasAttribute('allow_delete') && $model->allow_delete === false) {
            throw new ForbiddenHttpException('Deletion is not allowed for this record.');
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Record deleted.');

        return $this->redirect(['index']);
    }
}

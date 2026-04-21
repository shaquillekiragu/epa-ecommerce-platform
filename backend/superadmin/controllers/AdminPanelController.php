<?php

namespace superadmin\controllers;

use superadmin\models\User;

class AdminPanelController extends _SuperadminWebController
{
    /** @var class-string<\yii\db\ActiveRecord> */
    public $model_class;

    /** @var class-string<\superadmin\models\search\_BaseSearch> */
    public $search_model_class;

	public function actionIndex()
    {
        $model_class = $this->model_class ?? User::class;

        $data_provider = new \yii\data\ActiveDataProvider([
            'query' => $model_class::find(),
            'pagination' => ['pageSize' => 50],
        ]);

        return $this->render('@superadmin/views/admin-panel/index', [
            'data_provider' => $data_provider,
            'model_class' => $model_class,

        ]);

        // return 'Hello world!';
    }

    public function actionView($id)
    {
        
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

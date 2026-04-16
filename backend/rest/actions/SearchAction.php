<?php

namespace rest\actions;

class SearchAction extends \yii\base\Action
{
	public function run()
	{
		$model_class = $this->controller->model_class;
		$query = $model_class::find(); //build query

		Yii::$app->request->post('term');
	}
}
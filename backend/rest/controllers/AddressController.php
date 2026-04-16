<?php

namespace rest\controllers;

class AddressController extends \yii\rest\ActiveController
{
    public $model_class = "rest\models\Address";

	// actionSearch - post method - ($term, $page_num) - activeDataprovider - build a query and put into data provider - query can split words to use for searching
	// add search column to every table
	// 

	public function actions()
	{
		return array_merge(parent::actions, [
			'search' => \rest\actions\SearchAction::class
		]);
	}
}

// active data provider calls asArray() by default, override this - if i want to return specific fields like scenarios

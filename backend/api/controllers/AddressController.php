<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\rest\IndexAction;
use yii\data\ActiveDataFilter;
use api\models\Address;
use common\models\Address as CommonAddress;

class AddressController extends _ApiController
{
    public $modelClass = Address::class;

    // public function actions()
    // {
    //     $actions = parent::actions();

    //     return ArrayHelper::merge($actions, [
    //         'index' => [
    //             'class' => IndexAction::class,
    //             'modelClass' => $this->modelClass,
    //             'dataFilter' => [
    //                 'class' => ActiveDataFilter::class,
    //                 'searchModel' => CommonAddress::class
    //             ],
    //             'prepareSearchQuery' => function ($query, $request_params) {
    //                 return $query;
    //             }
    //         ]
    //     ]);
    // }
}

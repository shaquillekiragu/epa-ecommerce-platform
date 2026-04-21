<?php

use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\grid\ActionColumn;

/** @var \yii\data\ActiveDataProvider $data_provider */
/** @var class-string<\yii\db\ActiveRecord> $model_class */

$model = new $model_class();

echo GridView::widget([
    'dataProvider' => $data_provider,
    'columns' => array_merge(
        [['class' => SerialColumn::class]],
        $model->attributes(), // shows all DB columns
        [['class' => ActionColumn::class]]
    ),
]);

?>

<?php

use yii\grid\GridView;
use yii\grid\ActionColumn;

$model = new $model_class();

?>

<main class="my-5 mr-5">
    <?= GridView::widget([
        'dataProvider' => $data_provider,

        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],

        'rowOptions' => function ($model) {
            return [
                'style' => 'cursor:pointer',
                'onclick' => "window.location.href='" . \yii\helpers\Url::to(['view', 'id' => $model->id]) . "'",
            ];
        },

        'columns' => array_merge(
            $model->attributes(),
            [['class' => ActionColumn::class]]
        ),
    ]); ?>
</main>

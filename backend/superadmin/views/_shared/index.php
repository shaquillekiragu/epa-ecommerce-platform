<?php

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

$model = new $model_class();

$mask_secret_for_display = static function (?string $value): ?string {
    if ($value === null || $value === '') {
        return $value;
    }

    return '****************';
};

$columns = $model->attributes();

foreach ($columns as $i => $column) {
    if ($column !== 'hashed_password') {
        continue;
    }

    $columns[$i] = [
        'attribute' => 'hashed_password',
        'label' => $model->getAttributeLabel('hashed_password'),
        'value' => static fn ($row_model) => $mask_secret_for_display($row_model->hashed_password ?? null),
    ];
    break;
}

$action_column = [[
    'class' => ActionColumn::class,
    'template' => '{view} {update} {delete}',

    'urlCreator' => function ($action, $model) {
        $pk = $model->getPrimaryKey();
        return Url::to([$action, 'id' => $pk]);
    },

    'contentOptions' => ['class' => 'd-flex gap-2'],
    'buttonOptions' => ['class' => ''],

    'buttons' => [
        'delete' => function ($url, $model, $key) {
            return Html::a(
                'Delete',
                $url,
                [
                    'class' => 'btn btn-sm btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this record?',
                        'method' => 'post',
                    ],
                ]
            );
        },
        'view' => function ($url) {
            return Html::a('View', $url, ['class' => 'btn btn-sm btn-outline-primary']);
        },
        'update' => function ($url) {
            return Html::a('Update', $url, ['class' => 'btn btn-sm btn-outline-warning']);
        },
    ],
]];

?>

<main class="my-5 pe-4">
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $data_provider,
            // 'filterModel' => $filter_model,

            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],

            'rowOptions' => function ($model) {
                return [
                    'style' => 'cursor:pointer',
                    'onclick' => "window.location.href='" . Url::to(['view', 'id' => $model->id]) . "'",
                ];
            },

            'columns' => array_merge(
                $columns,
                $action_column
            ),
        ]); ?>
    </div>
</main>

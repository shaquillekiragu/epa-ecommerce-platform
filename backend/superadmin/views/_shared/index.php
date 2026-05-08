<?php

/**
 * Shared admin GridView listing.
 *
 * @var yii\data\ActiveDataProvider $data_provider
 * @var class-string<\yii\db\ActiveRecord>|null $model_class ActiveRecord backing this grid (provided by dashboard or inferred from `$data_provider->query`).
 */

use superadmin\models\User;
use yii\db\ActiveQuery;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

if (!isset($data_provider)) {
    throw new \yii\base\InvalidConfigException('Listing view requires `$data_provider` (ActiveDataProvider).');
}

$model_class = $model_class ?? null;

if (
    !is_string($model_class)
    || $model_class === ''
    || !class_exists($model_class)
) {
    $q = isset($data_provider->query) ? $data_provider->query : null;
    $resolved = (
        $q instanceof ActiveQuery
        && isset($q->modelClass)
        && is_string($q->modelClass)
        && $q->modelClass !== ''
        && class_exists($q->modelClass)
    )
        ? $q->modelClass
        : User::class;

    $model_class = $resolved;
}

$model = new $model_class();

$mask_secret_for_display = static function (?string $value): ?string {
    if ($value === null || $value === '') {
        return $value;
    }

    return '****************';
};

$columns = $model->attributes();

foreach ($columns as $i => $column) {
    if ($column === 'product_category_id' && method_exists($model, 'getProductCategoryName')) {
        $columns[$i] = [
            'attribute' => 'product_category_id',
            'label' => $model->getAttributeLabel('productCategoryName'),
            'value' => static fn ($row_model) => $row_model->productCategoryName ?? $row_model->product_category_id,
        ];
        continue;
    }

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
    'template' => '{view} {update}',

    'urlCreator' => function ($action, $model) {
        $pk = $model->getPrimaryKey();
        return Url::to([$action, 'id' => $pk]);
    },

    'contentOptions' => ['class' => 'd-flex gap-2'],
    'buttonOptions' => ['class' => ''],

    'buttons' => [
        'view' => function ($url) {
            return Html::a('View', $url, [
                'class' => 'btn btn-sm btn-outline-primary',
            ]);
        },
        'update' => function ($url) {
            return Html::a('Update', $url, [
                'class' => 'btn btn-sm btn-outline-warning',
            ]);
        },
    ],
]];

$no_creation = ['basketproduct', 'orderproduct', 'useraddress'];
$model_short_name = strtolower((new \ReflectionClass($model_class))->getShortName());

?>

<main class="my-5 pe-4">
    <?php if (!in_array($model_short_name, $no_creation, true)) { ?>
        <article class="d-flex justify-content-end">
            <?= Html::a('Create +', ['create'], ['class' => 'btn btn-outline-success']); ?>
        </article>
    <?php } ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $data_provider,
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

<?php

/** @var \yii\web\View $this */
/** @var string $content */

use superadmin\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
$menuItems = [
    ['label' => 'Home', 'url' => ['/']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
    'items' => $menuItems,
]);
if (Yii::$app->user->isGuest) {
    echo Html::tag('div', Html::a('Login', ['/site/login'], ['class' => ['btn btn-link login text-decoration-none']]), ['class' => ['d-flex']]);
} else {
    echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->email . ')',
            ['class' => 'btn btn-link logout text-decoration-none']
        )
        . Html::endForm();
}
NavBar::end();
?>
</header>

<main role="main" class="shrink-0">
    <div class="container">
        <?php
        $links = $this->params['breadcrumbs'] ?? [];

        $is_page_site_index = Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'index';

        if ($is_page_site_index) {
            array_unshift($links, 'Home');
        } else {
            array_unshift($links, ['label' => 'Home', 'url' => ['/']]);
        }
        ?>

        <?= Breadcrumbs::widget([
            'homeLink' => false,
            'links' => $links,
            'options' => [
                'class' => 'breadcrumb mt-3 fs-5',
                'style' => "--bs-breadcrumb-divider: ' > ';"
            ],
        ]); ?>

        <?= Alert::widget(); ?>
        <?= $content; ?>
    </div>
</main>

<footer class="footer mt-auto py-4 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();

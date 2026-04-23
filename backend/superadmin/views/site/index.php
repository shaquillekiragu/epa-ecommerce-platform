<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Superadmin Dashboard';

$data_entities = [
    [
        'title' => 'Users',
        'subtitle' => 'Accounts and roles',
        'url_param' => 'user',
    ],
    [
        'title' => 'Orders',
        'subtitle' => 'Purchases and status',
        'url_param' => 'order',
    ],
    [
        'title' => 'Products',
        'subtitle' => 'Catalogue and stock',
        'url_param' => 'product',
    ],
    [
        'title' => 'Product Categories',
        'subtitle' => 'Catalogue categories',
        'url_param' => 'productcategory',
    ],
    [
        'title' => 'Stores',
        'subtitle' => 'Merchants and stores',
        'url_param' => 'store',
    ],
    [
        'title' => 'Baskets',
        'subtitle' => 'Customers\' open baskets',
        'url_param' => 'basket',
    ],
    [
        'title' => 'Addresses',
        'subtitle' => 'Billing and shipping',
        'url_param' => 'address',
    ],
];

$linked_data_entities = [
    [
        'title' => 'Order-Products',
        'subtitle' => 'Order line items',
        'url_param' => 'orderproduct',
    ],
    [
        'title' => 'Basket-Products',
        'subtitle' => 'Basket line items',
        'url_param' => 'basketproduct',
    ],
    [
        'title' => 'User-Addresses',
        'subtitle' => 'User ↔ address links',
        'url_param' => 'useraddress',
    ],
];

?>

<main class="site-index">
    <div class="py-4 mb-5">
        <section class="p-4 p-md-5 rounded-3 bg-light border">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <h1 class="display-6 mb-2">Superadmin Dashboard</h1>
                    <p class="lead mb-0">
                        Manage platform data and operations. Use the Admin Panel to view records and perform CRUD actions.
                    </p>
                </div>

                <div class="col-12 col-lg-4 text-lg-end">
                    <?= Html::a(
                        'Open Admin Panel',
                        ['/admin-panel/index'],
                        ['class' => 'btn btn-primary btn-lg w-100 w-lg-auto']
                    ) ?>
                </div>
            </div>
        </section>

        <h3 class="mt-5">Data Entities</h3>

        <section class="row g-3 mt-3">
            <?php foreach($data_entities as $entity) { ?>
                <article class="col-12 col-md-6 col-xl-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="fw-semibold"><?= $entity['title'] ?></div>
                            <div class="text-muted small mb-3"><?= $entity['subtitle'] ?></div>
                            <?= Html::a('View ' . strtolower($entity['title']), ['/' . $entity['url_param'] . '/index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        </div>
                    </div>
                </article>
            <?php } ?>
        </section>

        <h3 class="mt-5">Linked Data Entities</h3>

        <section class="row g-3 mt-3">
            <?php foreach($linked_data_entities as $entity) { ?>
                <article class="col-12 col-md-6 col-xl-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="fw-semibold"><?= $entity['title'] ?></div>
                            <div class="text-muted small mb-3"><?= $entity['subtitle'] ?></div>
                            <?= Html::a('View ' . strtolower($entity['title']), ['/' . $entity['url_param'] . '/index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        </div>
                    </div>
                </article>
            <?php } ?>
        </section>
    </div>
</main>

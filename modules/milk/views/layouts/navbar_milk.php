<?php

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

?>
<nav class="mt2 ">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'main-header navbar navbar-expand navbar-green navbar-dark',
        ],
        'innerContainerOptions' => [
            'class' => 'container-fluid',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            '<li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>',
            ['label' => 'Maxsulotlar', 'url' => ['/milk/products/index'], 'visible' => true],
            [
                'label' => 'Ma\'lumotlar', 
                'items' => [
                    ['label' => 'Kunlar', 'url' => ['/milk/days/index'], 'iconStyle' => 'far'],
                    ['label' => 'Ishlab chiqarishlar', 'url' => ['/milk/productions/index'], 'iconStyle' => 'far'],
                    ['label' => 'Dillerlar', 'url' => ['/milk/dillers/index'], 'iconStyle' => 'far'],
                    ['label' => 'Xarajatlar', 'url' => ['/milk/expenses/index'], 'iconStyle' => 'far'],
                    ['label' => 'Qarzlar', 'url' => ['/milk/loans/index'], 'iconStyle' => 'far'],
                    ['label' => 'Kassa', 'url' => ['/milk/kassa/index'], 'iconStyle' => 'far'],
                    ['label' => 'Investitsiya', 'url' => ['/milk/investment/index'], 'iconStyle' => 'far'],
                    ['label' => 'Barcha maxsulotlar', 'url' => ['/milk/all-products/index'], 'iconStyle' => 'far'],
                ],
                'visible' => true, 
            ],
        ],
    ]);
    echo $this->render('../../../../views/layouts/navbar_right', ['assetDir' => $assetDir]);
    NavBar::end();
    ?>
</nav>
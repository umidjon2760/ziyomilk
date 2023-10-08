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
                    ['label' => 'Barcha maxsulotlar', 'url' => ['/milk/all-products/index'], 'iconStyle' => 'far'],
                    ['label' => 'Kunlar', 'url' => ['/milk/days/index'], 'iconStyle' => 'far']
                ],
                'visible' => true, 
            ],
        ],
    ]);
    echo $this->render('../../../../views/layouts/navbar_right', ['assetDir' => $assetDir]);
    NavBar::end();
    ?>
</nav>
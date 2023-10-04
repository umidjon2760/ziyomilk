<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\AdminNotes;
use app\models\Users;
?>
<!-- Right navbar links -->
<ul class="navbar-nav ml-auto top-right-menu">
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" title="Ички тизимлар">
            <i class="fas fa-th"></i>
        </a>
        
    </li>
    

    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle usr" data-toggle="dropdown">
            <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image">
            <span class="d-none d-md-inline">Admin</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-success">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

                <p>
                    Admin
                    <small>Admin</small>
                </p>
            </li>
            <!-- Menu Footer-->
            <li style="margin:3%;">
                <a href="?r=users/view&id=<?= Yii::$app->user->identity->id ?>" class="btn btn-success " style="width:125px;">Sahifam</a>
                <a href="?r=site/logout" class="btn btn-danger  float-right" data-method="POST" style="width:125px;" data-confirm="Тизимдан чиқмоқчимисиз?">Chqish</a>
            </li>
        </ul>
    </li>
    <!-- <li class="nav-item">
            <a class="nav-link y" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                    class="fas fa-th-large"></i></a>
        </li> -->
</ul>

<style type="text/css">
    .navbar-nav>.user-menu>.dropdown-menu>li.user-header>p {
        margin-top: 0;
    }
</style>
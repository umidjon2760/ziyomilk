<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Days $model */

$this->title = date('d.m.Y', strtotime($model->day));
$this->params['breadcrumbs'][] = ['label' => 'Kunlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card" id="prductions">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;margin-bottom:0px;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Ishlab chiqarish</i>
        </button>
    </div>
    <div class="card-body">
        <?php
        $productions = $model->productions;
        // debug($productions);
        Modal::begin([
            'title' => '<h2>Ishlab chiqarish ('.$this->title.')</h2>',
            'id' => 'your-modal-production',
            'size' => 'modal-lg'
        ]);
        echo Html::beginForm(['/milk/products/save-production',], 'post',);
        echo "<table class='table table-bordered  table-hover '>";
        echo "<tr>";
        echo "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        echo "<th style=width:65%;' class='hor-center ver-middle'>Maxsulot nomi</th>";
        echo "<th style=width:10%;' class='hor-center ver-middle'>Narxi</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Soni</th>";
        echo "</tr>";
        $t = 1;
        foreach ($products as $product) {
            $production_model = $product->production;
            $production_value = $production_model ? $production_model->count : 0;
            $production_id = $production_model ? $production_model->id : 0;
            echo "<input type='hidden' name='product_code[]' value='" . $product->code . "' />";
            echo "<input type='hidden' name='price[".$product->code."]' value='" . $product->price->price . "' />";
            echo "<input type='hidden' name='production_id[".$product->code."]' value='" . $production_id . "' />";
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $t . "</td>";
            echo "<td class='ver-middle'>" . $product->name . "</td>";
            echo "<td class='hor-center ver-middle'>" . number_format($product->price->price, 0, ',', ' ') . "</td>";
            echo "<td class='hor-center ver-middle'><input type='number'name='count[".$product->code."]' step='0.1' min='0' class='form-control' value='".$production_value."' /></td>";
            echo "</tr>";
            $t++;
        }
        echo "</table>";
        echo Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']);
        echo Html::endForm();
        Modal::end();
        echo "<button class='btn btn-primary'  data-toggle='modal' data-target='#your-modal-production'><i class='fas fa-plus'></i></button><br><br>";
        echo "<table class='table table-bordered  table-hover '>";
        echo "<tr>";
        echo "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        echo "<th style=width:60%;' class='hor-center ver-middle'>Maxsulot nomi</th>";
        echo "<th style=width:10%;' class='hor-center ver-middle'>Soni</th>";
        echo "<th style=width:10%;' class='hor-center ver-middle'>Narxi</th>";
        echo "<th style=width:10%;' class='hor-center ver-middle'>Jami</th>";
        echo "</tr>";
        $n = 1;
        $all = 0;
        foreach ($productions as $production) {
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $n . "</td>";
            echo "<td class='ver-middle'>" . $production->product->name . "</td>";
            echo "<td class='hor-center ver-middle'>" . $production->count . "</td>";
            echo "<td class='hor-center ver-middle'>" . number_format($production->price, 0, ',', ' ') . "</td>";
            echo "<td class='hor-center ver-middle'>" . number_format($production->count * $production->price, 0, ',', ' ') . "</td>";
            echo "</tr>";
            $n++;
            $all += $production->count * $production->price;
        }
        echo "<tr>";
        echo "<th colspan='4' class='text-right'>Jami</th>";
        echo "<th class='text-center'>" . number_format($all, 0, ',', ' ') . "</th>";
        echo "</tr>";
        echo "</table>";
        ?>
    </div>
</div>

<div class="card collapsed-card" id="dillers">
    <div class="card-header">
        <button type="button" style="width:100%;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Dillerlar</i>
        </button>
    </div>
    <div class="card-body">
        dfdss sfsfsfs fsfsf
    </div>
</div>
<style>
    .hor-center {
        text-align: center;
    }

    .ver-middle {
        vertical-align: middle;
    }
</style>
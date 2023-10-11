<?php

use app\modules\milk\models\Days;
use app\modules\milk\models\Products;
use yii\helpers\Html;

$open_day = Days::getOpenDay();
$day = date('d.m.Y', strtotime($open_day));
$this->title = $diller->name;
$this->params['breadcrumbs'][] = ['label' => $day, 'url' => ['view', 'id' => $day_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="days-index card">
    <div class="card-body">
        <a href="?r=milk/days/view&id=<?= $day_id ?>" class="btn btn-primary">Ortga</a><br><br>
        <?php
        echo Html::beginForm(['/milk/products/save-sellings',], 'post',);
        $products = Products::find()->where(['status' => true])->all();
        $str = "";
        $str .= "<input type='hidden' name='diller_id' value='" . $diller->id . "' />";
        $str .= "<table class='table table-bordered'>";
        $str .= "<tr>";
        $str .= "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        $str .= "<th  class='hor-center ver-middle'>Maxsulot nomi</th>";
        $str .= "<th style=width:10%;' class='hor-center ver-middle'>Narxi</th>";
        $str .= "<th style=width:10%;' class='hor-center ver-middle'>Olgan</th>";
        $str .= "<th style=width:10%;' class='hor-center ver-middle'>Qaytargan</th>";
        $str .= "<th style=width:10%;' class='hor-center ver-middle'>Jami</th>";
        $str .= "<th style=width:15%;' class='hor-center ver-middle'>Summa</th>";
        $str .= "</tr>";
        $n = 1;
        foreach ($products as $product) {
            $selling = $diller->getSelling($product->code, $open_day);
            $selling_id = $selling ? $selling->id : 0;
            $buy_value = $selling ? $selling->buy : 0;
            $return_value = $selling ? $selling->return : 0;
            $all = $buy_value - $return_value;
            $price = $product->price->price;
            $sum = $selling ? $selling->all_sum : 0;
            $str .= "<input type='hidden' name='product_code[]' value='" . $product->code . "' />";
            $str .= "<input type='hidden' name='selling_id[".$product->code."]' value='" . $selling_id . "' />";
            $str .= "<input type='hidden' name='price[".$product->code."]' value='" . $price . "' />";
            $str .= "<tr>";
            $str .= "<td style=width:3%;' class='hor-center ver-middle'>" . $n . "</td>";
            $str .= "<td  class='ver-middle'>" . $product->name . "</td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'>" . number_format($price, 0, ',', ' ') . "</td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'><input value='" . $buy_value . "' name='buy[" . $product->code . "]' id='" . $product->code . "_" . $diller->id . "' type='number' step='0.1' min='0' class='form-control'/></td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'><input value='" . $return_value . "' name='return[" . $product->code . "]' type='number' step='0.1' min='0' class='form-control'/></td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'>" . $all . "</td>";
            $str .= "<td style=width:15%;' class='hor-center ver-middle'>" . number_format($sum, 0, ',', ' ') . "</td>";
            $str .= "</tr>";
            $n++;
        }
        $str .= "</table>";
        echo $str;
        echo Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']);
        echo Html::endForm();
        ?>
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
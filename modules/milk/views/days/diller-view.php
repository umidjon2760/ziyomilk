<?php

use app\modules\milk\models\AllProducts;
use app\modules\milk\models\Days;
use app\modules\milk\models\Products;
use yii\helpers\Html;

$day = date('d.m.Y', strtotime($day_model->day));
$day_id = $day_model->id;
$status = $day_model->status;
$this->title = $diller->name;
$this->params['breadcrumbs'][] = ['label' => $day, 'url' => ['view', 'id' => $day_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="days-index card">
    <div class="card-body">
        <a href="?r=milk/days/view&id=<?= $day_id ?>&type=2" class="btn btn-primary">Ortga</a><br><br>
        <?php
        echo $status ? Html::beginForm(['/milk/products/save-sellings',], 'post',) : "";
        echo $status ? "<input type='hidden'name='day' class='form-control' value='" . $day_model->day . "' />" : "";
        $products = Products::find()->where(['status' => true])->all();
        $str = "";
        $str .= $status ? "<input type='hidden' name='diller_id' value='" . $diller->id . "' />" : "";
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
            $selling = $diller->getSelling($product->code, $day_model->day);
            $selling_id = $selling ? $selling->id : 0;
            $buy_value = $selling ? $selling->buy : 0;
            $return_value = $selling ? $selling->return : 0;
            $all = $buy_value - $return_value;
            $price = $product->price->price;
            $sum = $selling ? $selling->all_sum : 0;
            if ($status) {
                $all_products = AllProducts::find()->where(['product_code' => $product->code, 'day' => $day_model->day])->one();
                $reason = $all_products && $all_products->count > 0 ? "" : "<br><i style='color:red;'>Bu mahsulot skladda mavjud emas!!!</i>";
                $disabled = strlen($reason) > 5 ? "disabled" : "";
            } else {
                $reason = "";
                $disabled = "";
            }
            $str .= $status ? "<input type='hidden' name='product_code[]' value='" . $product->code . "' />" : "";
            $str .=  $status ? "<input type='hidden' name='selling_id[" . $product->code . "]' value='" . $selling_id . "' />" : "";
            $str .= $status ? "<input type='hidden' name='price[" . $product->code . "]' value='" . $price . "' />" : "";
            $str .= "<tr>";
            $str .= "<td style=width:3%;' class='hor-center ver-middle'>" . $n . "</td>";
            $str .= "<td  class='ver-middle'>" . $product->name . $reason . "</td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'>" . numberFormat($price, 0) . "</td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'>";
            $str .= $status ? "<input required ".$disabled." value='" . $buy_value . "' name='buy[" . $product->code . "]' id='" . $product->code . "_" . $diller->id . "' type='number' step='0.1' min='0' class='form-control'/>" : $buy_value;
            $str .= "</td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'>";
            $str .= $status ? "<input required ".$disabled." value='" . $return_value . "' name='return[" . $product->code . "]' type='number' step='0.1' min='0' class='form-control'/>" : $return_value;
            $str .= "</td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'>" . $all . "</td>";
            $str .= "<td style=width:15%;' class='hor-center ver-middle'>" . numberFormat($sum, 0) . "</td>";
            $str .= "</tr>";
            $n++;
        }
        $dillers_calc = $diller->getDillerCalcByDay($day_model->day) ? $diller->getDillerCalcByDay($day_model->day) : false;
        $value_all_sum = $dillers_calc ? $dillers_calc->all_sum : 0;
        $value_given_sum = $dillers_calc ? $dillers_calc->given_sum : 0;
        $value_loan_sum = $dillers_calc ? $dillers_calc->loan_sum : 0;
        $old_loan_sum = $dillers_calc ? $dillers_calc->old_loan_sum : 0;
        $str .= "<tr>";
        $str .= "<td colspan='6' class='text-right'><b>Jami</b></td>";
        $str .= "<td class='text-center'>" . numberFormat($value_all_sum, 0) . "</td>";
        $str .= "</tr>";
        $str .= "</table><br>";
        $str .= "<table class='table table-bordered'>";
        $str .= "<tr>";
        $str .= "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        $str .= "<th  class='hor-center ver-middle'>Diller</th>";
        $str .= "<th style=width:15%;' class='hor-center ver-middle'>Jami summa</th>";
        $str .= "<th style=width:15%;' class='hor-center ver-middle'>Bergan summa</th>";
        $str .= "<th style=width:15%;' class='hor-center ver-middle'>Oldingi qarz</th>";
        $str .= "<th style=width:15%;' class='hor-center ver-middle'>Umumiy qarz</th>";
        $str .= "</tr>";
        $str .= "<tr>";
        $str .= "<td style=width:3%;' class='hor-center ver-middle'>1</td>";
        $str .= "<td  class='ver-middle'>" . $diller->name . "</td>";
        $str .= "<td class='hor-center ver-middle'>" . numberFormat($value_all_sum, 0) . "</td>";
        $str .= "<td class='hor-center ver-middle'>";
        $str .= $status ? "<input type='number'name='given_sum' step='0.1' min='0' class='form-control' required value='" . $value_given_sum . "' />" : numberFormat($value_given_sum, 0);
        $str .= $status ? "<input type='hidden'name='old_loan_sum' step='0.1' min='0' class='form-control' value='" . $old_loan_sum . "' />" : numberFormat($old_loan_sum, 0);
        $str .= "</td>";
        $str .= "<td class='hor-center ver-middle'>" . numberFormat($old_loan_sum, 0) . "</td>";
        $str .= "<td class='hor-center ver-middle'>" . numberFormat($value_loan_sum + $old_loan_sum, 0) . "</td>";
        $str .= "</tr>";
        $str .= "</table>";
        echo $str;

        echo $status ? Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']) : "";
        echo $status ? Html::endForm() : "";
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
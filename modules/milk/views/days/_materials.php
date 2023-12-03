<?php

use app\modules\milk\models\DailyMaterials;
use app\modules\milk\models\Expenses;
use app\modules\milk\models\ExpenseSpr;
use app\modules\milk\models\Products;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$status = $model->status;

?>
<div class="card" id="materials">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Xom ashyo</i></h3>
        </button>
    </div>
    <div class="card-body">
        <?php
        $products = Products::find()->select('expense_code')->where('length(expense_code)>0')->orderBy(['name' => SORT_ASC])->all();
        $product_expensecodes = ArrayHelper::getColumn($products, 'expense_code');
        $other_materials = ExpenseSpr::find()->where(['type' => 'xomashyo'])->andWhere(['not in', 'code', $product_expensecodes])->orderBy(['code' => SORT_ASC])->all();
        $daily_materials = $model->dailyMaterials;
        $t = 1;
        $all_sum = 0;
        echo "<h3>Bugun ishlatilgan xom ashyolar</h3>";
        echo Html::beginForm(['/milk/products/save-materials',], 'post',);
        echo $status ? "<input type='hidden'name='day' class='form-control' value='" . $model->day . "' />" : "";
        echo "<table class='table table-bordered  table-hover '>";
        echo "<tr>";
        echo "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        echo "<th class='hor-center ver-middle'>Xom ashyo nomi</th>";
        echo "<th style=width:17%;' class='hor-center ver-middle'>Soni</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Narxi</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Summa</th>";
        echo "</tr>";
        $except_arr = [];
        if($status){
            foreach ($other_materials as $other_material) {
                $except_arr[] = $other_material->code;
                $expense = Expenses::find()->where(['expense_code' => $other_material->code])->andWhere(['<=','day',$model->day])->orderBy(['created_at' => SORT_ASC])->one();
                if ($expense) {
                    $daily_material = DailyMaterials::find()->where(['day' => $model->day, 'expense_code' => $other_material->code])->one();
                    $price = $expense->sum;
                    $disabled = "";
                    $value = $daily_material ?  $daily_material->count : 0;
                    $type = "type='number' step='0.1' min='0'";
                } else {
                    $price = 0;
                    $disabled = "disabled";
                    $value = "Skladda mavjud emas";
                    $type = "type='text'";
                }
                if ($value != 'Skladda mavjud emas') {
                    $sum = $value * $price;
                } else {
                    $sum = 0;
                }
                echo "<tr>";
                echo "<td class='hor-center ver-middle'>" . $t . "</td>";
                echo "<td class='ver-middle'>" . $other_material->name . "</td>";
                echo "<td class='hor-center ver-middle'>";
                echo $status ? "<input " . $disabled . " onkeyup='calc_sum(this," . $price . ");' name='count[" . $other_material->code . "]' id='count-" . $other_material->code . "' " . $type . " value='" . $value . "' class='form-control' />" : $value;
                echo "</td>";
                echo "<td class='hor-center ver-middle'>" . $price . "</td>";
                echo "<td id='allsum-" . $other_material->code . "' class='hor-center ver-middle'>" . numberFormat($sum, 0) . "</td>";
                echo "</tr>";
                $all_sum += $sum;
                $t++;
            }
        }
        foreach ($daily_materials as $daily_material) {
            if(!in_array($daily_material->expense_code,$except_arr)){
                $expense = Expenses::find()->where(['expense_code' => $daily_material->expense_code])->orderBy(['created_at' => SORT_DESC])->one();
                if ($expense) {
                    $price = $expense->sum;
                } else {
                    $price = 0;
                }
                $sum = $daily_material->count * $price;
                echo "<tr>";
                echo "<td class='hor-center ver-middle'>" . $t . "</td>";
                echo "<td class='ver-middle'>" . $daily_material->expenseCode->name . "</td>";
                echo "<td class='hor-center ver-middle'>" . $daily_material->count . "</td>";
                echo "<td class='hor-center ver-middle'>" . numberFormat($price, 0) . "</td>";
                echo "<td class='hor-center ver-middle'>" . numberFormat($sum, 0) . "</td>";
                echo "</tr>";
                $t++;
                $all_sum += $sum;
            }
        }
        echo "<tr>";
        echo "<td colspan='4' style=width:3%;' class='text-right ver-middle'>Jami</td>";
        echo "<td class='hor-center ver-middle'>" . numberFormat($all_sum, 0) . "</td>";
        echo "</tr>";
        echo "</table>";
        echo $status ? Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']) : "";
        echo Html::endForm();
        echo "<hr><hr>";
        ////-------------------------------------------------------------------------------------------////
        echo "<h3>Barcha xom ashyolar</h3>";
        echo "<table class='table table-bordered  table-hover '>";
        echo "<tr>";
        echo "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        echo "<th class='hor-center ver-middle'>Xom ashyo nomi</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Soni</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Narxi</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Summa</th>";
        echo "</tr>";
        $t = 1;
        $materials = $model->allMaterials;
        $all_sum = 0;
        foreach ($materials as $material) {
            $r = Expenses::find()->where(['expense_code' => $material->expense_code])->orderBy(['created_at' => SORT_DESC])->one();
            $price = $material->getExpense($model->day) ? $material->getExpense($model->day)->sum : ($r ? $r->sum : 0);
            $sum = $material->count * $price;
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $t . "</td>";
            echo "<td class='ver-middle'>" . $material->expenseCode->name . "</td>";
            echo "<td class='hor-center ver-middle'>" . $material->count . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($price, 0) . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($sum, 0) . "</td>";
            echo "</tr>";
            $t++;
            $all_sum += $sum;
        }
        echo "<tr>";
        echo "<td colspan='4' style=width:3%;' class='text-right ver-middle'>Jami</td>";
        echo "<td class='hor-center ver-middle'>" . numberFormat($all_sum, 0) . "</td>";
        echo "</tr>";
        echo "</table>";
        ?>
    </div>
</div>
<script>
    function calc_sum(element, price) {
        const my_array = element.id.split("-")
        const type = my_array[0]
        const expense_code = my_array[1]
        var id_count = element.id;
        var id_allsum = "allsum-" + expense_code;
        var allsum = price * element.value
        document.getElementById(id_allsum).innerHTML = numberWithProbel(allsum);
    }

    function numberWithProbel(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, " ");
    }
</script>
<?php

use app\modules\milk\models\AllMaterials;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

?>

<div class="card" id="prductions">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Ishlab chiqarish</i>
        </button>
    </div>
    <div class="card-body">
        <?php
        $productions = $model->productions;
        Modal::begin([
            'title' => '<h2>Ishlab chiqarish (' . $this->title . ')</h2>',
            'id' => 'your-modal-production',
            'size' => 'modal-lg'
        ]);
        echo Html::beginForm(['/milk/products/save-production',], 'post',);
        echo "<input type='hidden'name='day' class='form-control' value='" . $model->day . "' />";
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
            if ($model->status) {
                if (strlen($product->expense_code) > 0) {
                    $has_material_model = AllMaterials::find()->where(['expense_code' => $product->expense_code, 'day' => $model->day])->one();
                    $has_material = $has_material_model && $has_material->count > 0 ? true : false;
                } else {
                    $has_material = true;
                }
                $reason = $has_material ? "" : "<br><i style='color:red;'>(Bu mahsulot ishlab chiqarish uchun yetarli xomashyo mavjud emas!!!)</i>";
                $disabled = $has_material ? "" : " disabled ";
            } else {
                $reason = $production_value == 0 ? "<br><i style='color:red;'>(Yetarli xomashyo mavjud emasligi sababli mahsulot ishlab chiqarilmagan!!!)</i>" : 0;
                $disabled = " disabled ";
            }
            echo "<input type='hidden' name='product_code[]' value='" . $product->code . "' />";
            echo "<input type='hidden' name='price[" . $product->code . "]' value='" . $product->price->price . "' />";
            echo "<input type='hidden' name='production_id[" . $product->code . "]' value='" . $production_id . "' />";
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $t . "</td>";
            echo "<td class='ver-middle'>" . $product->name . $reason . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($product->price->price, 0) . "</td>";
            echo "<td class='hor-center ver-middle'><input ".$disabled." type='number'name='count[" . $product->code . "]' step='0.1' min='0' class='form-control' value='" . $production_value . "' /></td>";
            echo "</tr>";
            $t++;
        }
        echo "</table>";
        echo Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']);
        echo Html::endForm();
        Modal::end();
        echo $model->status == true ? "<button class='btn btn-primary'  data-toggle='modal' data-target='#your-modal-production'><i class='fas fa-plus'></i></button><br><br>" : "";
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
            echo "<td class='hor-center ver-middle'>" . numberFormat($production->price, 0) . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($production->count * $production->price, 0) . "</td>";
            echo "</tr>";
            $n++;
            $all += $production->count * $production->price;
        }
        echo "<tr>";
        echo "<th colspan='4' class='text-right'>Jami</th>";
        echo "<th class='text-center'>" . numberFormat($all, 0) . "</th>";
        echo "</tr>";
        echo "</table>";
        ?>
    </div>
</div>
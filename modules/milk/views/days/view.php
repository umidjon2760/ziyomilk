<?php

use app\assets\AppAsset;
use unclead\multipleinput\MultipleInput;
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
<div class="card collapsed-card" id="prductions">
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
            echo "<input type='hidden' name='price[" . $product->code . "]' value='" . $product->price->price . "' />";
            echo "<input type='hidden' name='production_id[" . $product->code . "]' value='" . $production_id . "' />";
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $t . "</td>";
            echo "<td class='ver-middle'>" . $product->name . "</td>";
            echo "<td class='hor-center ver-middle'>" . number_format($product->price->price, 0, ',', ' ') . "</td>";
            echo "<td class='hor-center ver-middle'><input type='number'name='count[" . $product->code . "]' step='0.1' min='0' class='form-control' value='" . $production_value . "' /></td>";
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
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Dillerlar</i>
        </button>
    </div>
    <div class="card-body">
        <?php
        echo "<table class='table table-bordered  table-hover '>";
        echo "<tr>";
        echo "<th style='width:2%;' class='hor-center ver-middle'>#</th>";
        echo "<th  class='hor-center ver-middle'>Diller</th>";
        foreach ($products as $product) {
            echo "<th style='width:5%;' class='hor-center ver-middle'>" . $product->name . "</th>";
        }
        echo "<th style='width:5%;' class='hor-center ver-middle'>Ko'rish</th>";
        echo "</tr>";
        $n = 1;
        foreach ($dillers as $diller) {
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $n . "</td>";
            echo "<td class='ver-middle'>" . $diller->name . "</td>";
            foreach ($products as $product) {
                $selling = $diller->getSelling($product->code, $model->day);
                echo "<td class='hor-center ver-middle'>";
                echo $selling ? $selling->buy : 0;
                echo "</td>";
            }
            echo "<td style='width:5%;' class='hor-center ver-middle'><a href='?r=milk/days/diller-view&id=" . $diller->id . "&day_id=" . $model->id . "' class='btn btn-sm btn-info'>Ko'rish</a></td>";
            echo "</tr>";
            $n++;
        }
        echo "</table>";
        ?>
    </div>
</div>
<div class="card" id="xarajatlar">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Xarajatlar</i>
        </button>
    </div>
    <div class="card-body">
        <?php
        echo Html::beginForm(['/milk/products/save-expenses',], 'post',);

        echo MultipleInput::widget([
            'max' => 50,
            'min' => 1,
            'name' => 'multipleinput',
            'columns' => [
                [
                    'name'  => 'expense_code',
                    'type'  => 'dropDownList',
                    'title' => 'Xarajatni tanlang',
                    'items' => ['' => 'Tanlang...'] + $expense_spr,
                    'headerOptions' => [
                        'style' => 'width: 40%;',
                    ],
                ],
                [
                    'name'  => 'count',
                    'title' => 'Soni',
                    'defaultValue' => 0,
                    'type'  => 'textInput',
                ],
                [
                    'name'  => 'price',
                    'defaultValue' => 0,
                    'title' => 'Narxi',
                ],
                [
                    'name'  => 'given_sum',
                    'defaultValue' => 0,
                    'title' => 'Berilgan summa',
                ],
            ],    
        ]);
        echo Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']);
        echo Html::endForm();
        echo "<br><table class='table table-bordered table-hover'>";
        echo "<tr>";
        echo "<th style='width:2%;' class='hor-center ver-middle'>#</th>";
        echo "<th class='hor-center ver-middle'>Xarajat nomi</th>";
        echo "<th style='width:8%;' class='hor-center ver-middle'>Soni</th>";
        echo "<th style='width:12%;' class='hor-center ver-middle'>Narxi</th>";
        echo "<th style='width:12%;' class='hor-center ver-middle'>Jami summa</th>";
        echo "<th style='width:12%;' class='hor-center ver-middle'>Berilgan summa</th>";
        echo "<th style='width:12%;' class='hor-center ver-middle'>Qarz</th>";
        echo "</tr>";
        echo "</table>";
        ?>
    </div>
</div>
<style>
    .glyphicon {
        font-family: "Font Awesome 5 Free";
        font-weight: bold;
    }

    .glyphicon-plus::before {
        content: "\002b";
    }

    .glyphicon-remove:before {
        content: "\2212";
    }

    .hor-center {
        text-align: center;
    }

    .ver-middle {
        vertical-align: middle;
    }
</style>
<script>
    function modal(diller_id) {
        $.ajax({
            url: "?r=milk/days/get-modal",
            type: "POST",
            data: ({
                diller_id: diller_id,
                _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
            }),
            success: function(data) {
                console.log(data)
                document.getElementById("div_" + diller_id).innerHTML = data
            }
        });
    }
</script>
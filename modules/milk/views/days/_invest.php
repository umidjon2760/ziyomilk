<?php

use yii\helpers\Html;

?>
<div class="card" id="investment">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Investitsiya</i></h3>
        </button>
    </div>
    <div class="card-body">
        <?php
        $value_invest = $model->investment ? $model->investment->sum : 0;
        $value_comment = $model->investment ? $model->investment->comment : "";
        echo Html::beginForm(['/milk/products/save-invest',], 'post');
        echo "<input type='hidden'name='day' class='form-control' value='" . $model->day . "' />";
        echo "<table class='table table-bordered  table-hover '>";
        echo "<tr>";
        echo "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        echo "<th class='hor-center ver-middle'>Kun</th>";
        echo "<th style=width:30%;' class='hor-center ver-middle'>Investitsiya (so'm)</th>";
        echo "<th style=width:50%;' class='hor-center ver-middle'>Izoh</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td style=width:3%;' class='hor-center ver-middle'>1</td>";
        echo "<td class='hor-center ver-middle'>" . date('d.m.Y', strtotime($model->day)) . "</td>";
        echo "<td class='hor-center ver-middle'><input value='" . $value_invest . "' type='number' required name='invest' step='1' min='1'  class='form-control'  /></td>";
        echo "<td class='hor-center ver-middle'><textarea rows='1' placeholder='Izoh kiriting ...' name='comment' class='form-control'  >" . $value_comment . "</textarea></td>";
        echo "</tr>";
        echo "</table>";
        echo Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']);
        echo Html::endForm();
        ?>
    </div>
</div>
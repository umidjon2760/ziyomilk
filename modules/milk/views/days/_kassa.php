<?php

use yii\helpers\Html;

?>
<div class="card" id="kassa">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Kassa</i></h3>
        </button>
    </div>
    <div class="card-body">
        <?php
        $value_kassa = $model->kassa ? $model->kassa->sum : 0;
        echo Html::beginForm(['/milk/products/save-kassa',], 'post');
        echo "<input type='hidden'name='day' class='form-control' value='" . $model->day . "' />";
        echo "<table class='table table-bordered  table-hover '>";
        echo "<tr>";
        echo "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        echo "<th class='hor-center ver-middle'>Kun</th>";
        echo "<th style=width:40%;' class='hor-center ver-middle'>Kassa (so'm)</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td style=width:3%;' class='hor-center ver-middle'>1</td>";
        echo "<td class='hor-center ver-middle'>" . date('d.m.Y', strtotime($model->day)) . "</td>";
        echo "<td style=width:40%;' class='hor-center ver-middle'><input value='" . $value_kassa . "' type='number' required name='kassa' step='1' min='1'  class='form-control'  /></td>";
        echo "</tr>";
        echo "</table>";
        echo Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']);
        echo Html::endForm();
        ?>
    </div>
</div>
<?php

use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;

?>
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
            'data' => $data,
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
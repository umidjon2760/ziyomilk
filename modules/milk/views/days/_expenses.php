<?php

use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;

$status = $model->status;

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
        echo $status ? "<input type='hidden'name='day' class='form-control' value='" . $model->day . "' />" : "";
        echo $status ? MultipleInput::widget([
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
        ]) : "";
        echo $status ? Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']) : "";
        echo Html::endForm();
        $str = "";
        $str .= "<table class='table table-bordered table-hover'>";
        $str .= "<tr>";
        $str .= "<th style='width:2%;' class='hor-center ver-middle'>#</th>";
        $str .= "<th class='hor-center ver-middle'>Xarajat nomi</th>";
        $str .= "<th style='width:8%;' class='hor-center ver-middle'>Soni</th>";
        $str .= "<th style='width:12%;' class='hor-center ver-middle'>Narxi</th>";
        $str .= "<th style='width:12%;' class='hor-center ver-middle'>Jami summa</th>";
        $str .= "<th style='width:12%;' class='hor-center ver-middle'>Berilgan summa</th>";
        $str .= "<th style='width:12%;' class='hor-center ver-middle'>Qarz</th>";
        $str .= "</tr>";
        $t = 1;
        if(!$status){
            foreach ($model->expenses as $expense) {
                $str .= "<tr>";
                $str .= "<td class='hor-center ver-middle'>".$t."</td>";
                $str .= "<td>".$expense->expenseCode->name."</td>";
                $str .= "<td class='hor-center ver-middle'>".$expense->count."</td>";
                $str .= "<td class='hor-center ver-middle'>".numberFormat($expense->sum,0)."</td>";
                $str .= "<td class='hor-center ver-middle'>".numberFormat($expense->all_sum,0)."</td>";
                $str .= "<td class='hor-center ver-middle'>".numberFormat($expense->given_sum,0)."</td>";
                $str .= "<td class='hor-center ver-middle'>".numberFormat($expense->all_sum - $expense->given_sum,0)."</td>";
                $str .= "</tr>";
                $t++;
            }
        }
        $str .= "</table>";
        echo !$status ? $str : "";
        ?>
    </div>
</div>
<?php

use yii\helpers\Html;

$status = $model->status;

?>
<div class="card" id="loans">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Qarzlar</i></h3>
        </button>
    </div>
    <div class="card-body">
        <?php
        // debug($loans);
        echo $status ? Html::beginForm(['/milk/products/save-loans',], 'post',) : "";
        echo $status ? "<input type='hidden'name='day' class='form-control' value='" . $model->day . "' />" : "";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr>";
        echo "<th style='width:2%;' class='hor-center ver-middle'>#</th>";
        echo "<th class='hor-center ver-middle'>Qarz nomi</th>";
        echo "<th style='width:8%;' class='hor-center ver-middle'>Soni</th>";
        echo "<th style='width:12%;' class='hor-center ver-middle'>Narxi</th>";
        echo "<th style='width:12%;' class='hor-center ver-middle'>Jami summa</th>";
        echo "<th style='width:12%;' class='hor-center ver-middle'>Berilgan summa</th>";
        echo "<th style='width:12%;' class='hor-center ver-middle'>Bugun berilgan summa</th>";
        echo "<th style='width:12%;' class='hor-center ver-middle'>Qarz</th>";
        echo "</tr>";
        $l = 1;
        foreach ($loans as $loan) {
            $loans_calc_sum = 0;
            $loans_calc_str = "";
            foreach ($loan->loansCalcs as $loansCalc) {
                $loans_calc_sum += $loansCalc->given_sum;
                $loans_calc_str .= " + " . numberFormat($loansCalc->given_sum, 0);
            }
            echo $status ? "<input type='hidden'name='loan_id[]' class='form-control' value='" . $loan->id . "' />" : "";
            $expense = $loan->expense;
            $value_given_sum = $loan->getLoansCalc($model->day) ? $loan->getLoansCalc($model->day)->given_sum : 0;
            echo "<tr>";
            echo "<td>" . $l . "</td>";
            echo "<td>" . $expense->expenseCode->name . " (" . date('d.m.Y', strtotime($expense->day)) . ")" . "</td>";
            echo "<td class='hor-center'>" . $expense->count . "</td>";
            echo "<td class='hor-center'>" . numberFormat($expense->sum, 0) . "</td>";
            echo "<td class='hor-center'>" . numberFormat($expense->all_sum, 0) . "</td>";
            echo "<td class='hor-center'>" . numberFormat($expense->given_sum, 0) . " " . $loans_calc_str . "</td>";
            echo "<td class='hor-center'>";
            echo $status ? "<input type='number' name='given_sum[" . $loan->id . "]' step='1' min='1' max='" . $loan->loan_sum . "' class='form-control' value='" . $value_given_sum . "' />" : numberFormat($value_given_sum,0);
            echo "</td>";
            echo "<td class='hor-center'>" . numberFormat($loan->loan_sum - $loans_calc_sum, 0) . "</td>";
            echo "</tr>";
            $l++;
        }
        echo "</table>";
        echo $status ? Html::submitButton('<span class="fas fa-check-circle"></span> Saqlash', ['class' => 'submit btn btn-success btn-sm']) : "";
        echo $status ? Html::endForm() : "";
        ?>
    </div>
</div>
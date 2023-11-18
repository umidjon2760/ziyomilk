<div class="card" id="dillers">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Dillerlar</i>
        </button>
    </div>
    <div class="card-body">
        <?php
        echo "<table class='table table-bordered  table-hover ' style='font-size:9pt;'>";
        echo "<tr>";
        echo "<th style='width:2%;' class='hor-center ver-middle'>#</th>";
        echo "<th  class='hor-center ver-middle'>Diller</th>";
        $td_count = 0;
        foreach ($products as $product) {
            $td_count++;
            echo "<th style='width:4%;' class='hor-center ver-middle'>" . $product->name . "</th>";
        }
        echo "<th style='width:4%;' class='hor-center ver-middle'>Bergan summa</th>";
        echo "<th style='width:4%;' class='hor-center ver-middle'>Qarz</th>";
        echo "<th style='width:4%;' class='hor-center ver-middle'>Jami summa</th>";
        echo "<th style='width:4%;' class='hor-center ver-middle'>Ko'rish</th>";
        echo "</tr>";
        $n = 1;
        $all_given_sum = 0;
        $all_loan_sum = 0;
        $all_old_loan_sum = 0;
        $all_all_sum = 0;
        foreach ($dillers as $diller) {
            $dillers_calc = $diller->getDillerCalcByDay($model->day);
            if ($dillers_calc) {
                $given_sum = $dillers_calc->given_sum;
                $loan_sum = $dillers_calc->loan_sum;
                $old_loan_sum = $dillers_calc->old_loan_sum;
                $all_sum = $dillers_calc->all_sum;
            } else {
                $given_sum = 0;
                $loan_sum = 0;
                $old_loan_sum = 0;
                $all_sum = 0;
            }
            $all_given_sum += $given_sum;
            $all_loan_sum += $loan_sum;
            $all_old_loan_sum += $old_loan_sum;
            $all_all_sum += $all_sum;
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $n . "</td>";
            echo "<td class='ver-middle'>" . $diller->name . "</td>";
            foreach ($products as $product) {
                $selling = $diller->getSelling($product->code, $model->day);
                echo "<td class='hor-center ver-middle'>";
                echo $selling ? $selling->buy - $selling->return : 0;
                echo "</td>";
            }
            echo "<td class='hor-center ver-middle'>" . numberFormat($given_sum, 0) . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($loan_sum, 0) . "<br>" . numberFormat($old_loan_sum, 0) . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($all_sum, 0) . "</td>";
            echo "<td style='width:5%;' class='hor-center ver-middle'><a href='?r=milk/days/diller-view&id=" . $diller->id . "&day_id=" . $model->id . "' class='btn btn-sm btn-info'>Ko'rish</a></td>";
            echo "</tr>";
            $n++;
        }
        $colspan = $td_count + 2;
        echo "<tr>";
        echo "<td colspan='" . $colspan . "' class='text-right'><b>Jami</b></td>";
        echo "<td class='hor-center ver-middle'>" . numberFormat($all_given_sum, 0) . "</td>";
        echo "<td class='hor-center ver-middle'>" . numberFormat($all_loan_sum, 0) . "<br>" . numberFormat($all_old_loan_sum, 0) . "</td>";
        echo "<td class='hor-center ver-middle'>" . numberFormat($all_all_sum, 0) . "</td>";
        echo "<td></td>";
        echo "</tr>";
        echo "</table>";
        ?>
    </div>
</div>
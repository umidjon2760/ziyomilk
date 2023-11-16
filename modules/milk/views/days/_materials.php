<div class="card" id="materials">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Xom ashyo</i></h3>
        </button>
    </div>
    <div class="card-body">
        <?php
        echo "<h3>Bugun ishlatilgan xom ashyolar</h3>";
        echo "<table class='table table-bordered  table-hover '>";
        echo "<tr>";
        echo "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        echo "<th class='hor-center ver-middle'>Xom ashyo nomi</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Soni</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Narxi</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Summa</th>";
        echo "</tr>";
        $t = 1;
        $daily_materials = $model->dailyMaterials;
        $all_sum = 0; 
        foreach ($daily_materials as $daily_material) {
            $price = $daily_material->getExpense($model->day)->sum;
            $sum = $daily_material->count * $price;
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $t . "</td>";
            echo "<td class='ver-middle'>" . $daily_material->expenseCode->name . "</td>";
            echo "<td class='hor-center ver-middle'>" . $daily_material->count . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($price,0) . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($sum,0) . "</td>";
            echo "</tr>";
            $t++;
            $all_sum += $sum;
        }
        echo "<tr>";
        echo "<td colspan='4' style=width:3%;' class='text-right ver-middle'>Jami</td>";
        echo "<td class='hor-center ver-middle'>".numberFormat($all_sum,0)."</td>";
        echo "</tr>";
        echo "</table>";
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
            $price = $material->getExpense($model->day)->sum;
            $sum = $material->count * $price;
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $t . "</td>";
            echo "<td class='ver-middle'>" . $material->expenseCode->name . "</td>";
            echo "<td class='hor-center ver-middle'>" . $material->count . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($price,0) . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($sum,0) . "</td>";
            echo "</tr>";
            $t++;
            $all_sum += $sum;
        }
        echo "<tr>";
        echo "<td colspan='4' style=width:3%;' class='text-right ver-middle'>Jami</td>";
        echo "<td class='hor-center ver-middle'>".numberFormat($all_sum,0)."</td>";
        echo "</tr>";
        echo "</table>";
        ?>
    </div>
</div>
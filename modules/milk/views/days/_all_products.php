<div class="card" id="all_products">
    <div class="card-header">
        <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <h3 class="card-title" style="color:black;">Sklad</i></h3>
        </button>
    </div>
    <div class="card-body">
        <?php
        echo "<table class='table table-bordered  table-hover '>";
        echo "<tr>";
        echo "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        echo "<th class='hor-center ver-middle'>Maxsulot nomi</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Soni</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Narxi</th>";
        echo "<th style=width:15%;' class='hor-center ver-middle'>Summa</th>";
        echo "</tr>";
        $t = 1;
        $all_products = $model->allProducts ? $model->allProducts : $model->lastAllProduct();
        $all_sum = 0; 
        foreach ($all_products as $all_product) {
            $price = $all_product->product->price->price;
            $sum = $all_product->count * $price;
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $t . "</td>";
            echo "<td class='ver-middle'>" . $all_product->product->name . "</td>";
            echo "<td class='hor-center ver-middle'>" . $all_product->count . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($price,0) . "</td>";
            echo "<td class='hor-center ver-middle'>" . numberFormat($sum,0) . "</td>";
            echo "</tr>";
            $t++;
            $all_sum += $sum;
        }
        echo "<tr>";
        echo "<td colspan='4' style=width:3%;' class='hor-center ver-middle'>Jami</td>";
        echo "<td class='hor-center ver-middle'>".numberFormat($all_sum,0)."</td>";
        echo "</tr>";
        echo "</table>";
        ?>
    </div>
</div>
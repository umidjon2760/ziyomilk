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
        echo "</tr>";
        $t = 1;
        $all_products = $model->allProducts ? $model->allProducts : $model->lastAllProduct();
        foreach ($all_products as $all_product) {
            echo "<tr>";
            echo "<td class='hor-center ver-middle'>" . $t . "</td>";
            echo "<td class='ver-middle'>" . $all_product->product->name . "</td>";
            echo "<td class='hor-center ver-middle'>" . $all_product->count . "</td>";
            echo "</tr>";
            $t++;
        }
        echo "</table>";
        ?>
    </div>
</div>
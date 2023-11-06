<div class="card" id="dillers">
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
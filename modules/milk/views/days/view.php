<?php

use yii\bootstrap4\Modal;

$this->title = date('d.m.Y', strtotime($model->day));
$this->params['breadcrumbs'][] = ['label' => 'Kunlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$arr = [
    1 => "Ishlab chiqarish",
    2 => "Dillerlar",
    3 => "Xarajatlar",
    4 => "Qarzlar",
    5 => "Xom ashyo",
    6 => "Sklad",
    7 => "Investitsiya",
    8 => "Kassa",
];
$arr_width = [
    1 => "width:13%;",
    2 => "width:13%;",
    3 => "width:13%;",
    4 => "width:11%;",
    5 => "width:13%;",
    6 => "width:13%;",
    7 => "width:13%;",
    8 => "width:12%;",
];
$status = $model->status;
?>
<div class="card" id="menu">
    <div class='card-body'>
        <table class='table table-bordered'>
            <tr>
                <?php
                foreach ($arr as $key => $value) {
                    $style = $type == $key ? "style='background:#17A2B8;" . $arr_width[$key] . "'" : "style='background-color:white;" . $arr_width[$key] . "'";
                    $style_a = $type == $key ? "style='color:white;'" : "";
                    echo '<td ' . $style . ' class="hor-center ver-middle"><a href="?r=milk/days/view&id=' . $model->id . '&type=' . $key . '" ' . $style_a . '>' . $value . '</a></td>';
                }
                ?>
            </tr>
        </table>
    </div>
</div>

<?php
switch ($type) {
    case 1:
        echo $this->render('_productions', [
            'model' => $model,
            'products' => $products
        ]);
        break;
    case 2:
        echo $this->render('_dillers', [
            'model' => $model,
            'products' => $products,
            'dillers' => $dillers
        ]);
        break;
    case 3:
        echo $this->render('_expenses', [
            'model' => $model,
            'expense_spr' => $expense_spr,
            'data' => $data
        ]);
        break;
    case 4:
        echo $this->render('_loans', [
            'model' => $model,
            'loans' => $loans
        ]);
        break;
    case 5:
        echo $this->render('_materials', [
            'model' => $model,
        ]);
        break;
    case 6:
        echo $this->render('_all_products', [
            'model' => $model
        ]);
        break;
    case 7:
        echo $this->render('_invest', [
            'model' => $model
        ]);
        break;
    case 8:
        echo $this->render('_kassa', [
            'model' => $model
        ]);
        break;
    default:
        echo "Topilmadi";
        break;
}
if ($status) :
?>
    <div class="card collapsed-card">
        <div class="card-header">
            <button type="button" style="width:100%;color:black;font-size:13pt;border:1px solid white;text-align:left;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <h3 class="card-title" style="color:black;">Kun yopish</i>
            </button>
        </div>
        <div class="card-body">
            <?php
            Modal::begin([
                'title' => '<h2>Kun yopish - ' . date('d.m.Y', strtotime($model->day)) . '</h2>',
                'id' => 'your-modal-end-day',
                'size' => 'modal-md'
            ]);
            echo "<div>";
            // echo "<p>Barcha xolatlarni tekshirib chiqdingizmi? Kun yopilgandan so'ng shu kunga boshqa amaliyot bajara olmaysiz. Rozimisiz?</p>";
            echo "<p>Kun yopishdan avval qilgan amaliyotlaringizni tekshirishing!!!</p>";
            echo "<div id='end_day'>";
            echo "</div>";
            echo "<button id='btn_end_day' onclick='end_day();' class='btn btn-success'><span class='fas fa-check-circle'></span> Tekshirish</button>";
            echo "</div>";
            Modal::end();
            ?>
            <button class='btn btn-danger' data-toggle='modal' data-target='#your-modal-end-day'>Kun yopish</button>
        </div>
    </div>
<?php endif; ?>
<style>
    .glyphicon {
        font-family: "Font Awesome 5 Free";
        font-weight: bold;
    }

    .glyphicon-plus::before {
        content: "\002b";
    }

    .glyphicon-remove:before {
        content: "\2212";
    }

    .hor-center {
        text-align: center;
    }

    .ver-middle {
        vertical-align: middle;
    }
</style>
<script>
    function modal(diller_id) {
        $.ajax({
            url: "?r=milk/days/get-modal",
            type: "POST",
            data: ({
                diller_id: diller_id,
                _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
            }),
            success: function(data) {
                document.getElementById("div_" + diller_id).innerHTML = data
            }
        });
    }

    function end_day() {
        $.ajax({
            url: "?r=milk/days/check-close-day",
            type: "POST",
            data: ({
                day: '<?= $model->day ?>',
                _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
            }),
            success: function(data) {
                document.getElementById("btn_end_day").style.display = "none"
                document.getElementById("end_day").innerHTML = data
            }
        });
    }
</script>
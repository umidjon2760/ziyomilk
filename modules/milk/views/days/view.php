<?php
$this->title = date('d.m.Y', strtotime($model->day));
$this->params['breadcrumbs'][] = ['label' => 'Kunlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$arr = [
    1 => "Ishlab chiqarish",
    2 => "Dillerlar",
    3 => "Xarajatlar",
    4 => "Qarzlar",
    5 => "Barcha maxsulotlar",
    6 => "Investitsiya",
    7 => "Kassa",
];
$arr_width = [
    1 => "width:17%;",
    2 => "width:13%;",
    3 => "width:13%;",
    4 => "width:13%;",
    5 => "width:17%;",
    6 => "width:13%;",
    7 => "width:13%;",
];
?>
<div class="card" id="menu">
    <div class='card-body'>
        <table class='table table-bordered'>
            <tr>
                <?php
                foreach ($arr as $key => $value) {
                    $style = $type == $key ? "style='background:#17A2B8;".$arr_width[$key]."'" : "style='background-color:white;".$arr_width[$key]."'";
                    $style_a = $type == $key ? "style='color:white;'" : "";
                    echo '<td '.$style.' class="hor-center ver-middle"><a href="?r=milk/days/view&id='.$model->id.'&type='.$key.'" '.$style_a.'>'.$value.'</a></td>';
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
        echo $this->render('_all_products', [
            'model' => $model
        ]);
        break;
    case 6:
        echo $this->render('_invest', [
            'model' => $model
        ]);
        break;
    case 7:
        echo $this->render('_kassa', [
            'model' => $model
        ]);
        break;
    default:
        echo "Topilmadi";
        break;
}
?>
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
                console.log(data)
                document.getElementById("div_" + diller_id).innerHTML = data
            }
        });
    }
</script>
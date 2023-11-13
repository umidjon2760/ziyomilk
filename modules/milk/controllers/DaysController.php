<?php

namespace app\modules\milk\controllers;

use app\modules\milk\models\AllProducts;
use app\modules\milk\models\Days;
use app\modules\milk\models\DaysSearch;
use app\modules\milk\models\Dillers;
use app\modules\milk\models\DillersCalc;
use app\modules\milk\models\Expenses;
use app\modules\milk\models\ExpenseSpr;
use app\modules\milk\models\Kassa;
use app\modules\milk\models\Loans;
use app\modules\milk\models\LoansCalc;
use app\modules\milk\models\Productions;
use app\modules\milk\models\Products;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * DaysController implements the CRUD actions for Days model.
 */
class DaysController extends Controller
{
    /**
     * @inheritDoc
     */
    public $layout = 'milk';
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'close-day' => ['POST'],
                        'check-close-day' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Days models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DaysSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->orderBy(['day' => SORT_DESC]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Days model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $type = 1)
    {
        $day = $this->findModel($id);
        $products = Products::find()->where(['status' => true])->all();
        $dillers = Dillers::find()->where(['status' => true])->all();
        $expense_spr = ArrayHelper::map(ExpenseSpr::getAll(), 'code', 'name');
        $data = [];
        $expenses = Expenses::find()->where(['day' => $day->day])->all();
        foreach ($expenses as $expense) {
            if (!$expense->loan) {
                $given_sum = $expense->count * $expense->sum;
            } else {
                $given_sum = ($expense->count * $expense->sum) - $expense->loan->loan_sum;
            }
            $data[] = [
                'expense_code' => $expense->expense_code,
                'count' => $expense->count,
                'price' => $expense->sum,
                'given_sum' => $given_sum,
            ];
        }
        $loans = Loans::find()->alias('l')->where([
            'or',
            ['in', 'l.id', LoansCalc::find()->alias('lc')->select('lc.loan_id')->where('l.loan_sum > lc.given_sum')],
            ['not in', 'l.id', LoansCalc::find()->alias('lcc')->select('lcc.loan_id')],
            ['in', 'l.id', LoansCalc::find()->alias('lc')->select('lc.loan_id')->where(['lc.day' => $day->day])]
        ])->orderBy(['l.loan_sum' => SORT_DESC])->all();
        // $loans = Loans::find()->alias('l')->where(['in', 'l.id',LoansCalc::find()->alias('lc')->select('lc.loan_id')->where(['lc.day' => $day->day])])->orderBy(['l.loan_sum' => SORT_DESC])->all();
        return $this->render('view', [
            'model' => $day,
            'products' => $products,
            'expense_spr' => $expense_spr,
            'dillers' => $dillers,
            'data' => $data,
            'type' => $type,
            'loans' => $loans
        ]);
    }

    /**
     * Creates a new Days products.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Days();

        if ($this->request->isPost) {
            $old_day = Days::find()->max('day');
            if ($model->load($this->request->post())) {
                if ($model->save()) {
                    $now = date('Y-m-d H:i:s');
                    $new_day = $model->day;
                    // yangi kun ochilyotganda dillerlarga yangi kunga eski qarzlarni yozish
                    // yangi kun ochilyotganda eski kundegi barcha maxsulotlarni yangi kunga yozib qo'yish kerak
                    // yangi kun ochilyotganda eski kundegi kassadagi pullarni yangi kunga old_day_sum ga yozib qo'yish kerak
                    $dillers_calc = DillersCalc::find()->where(['day' => $old_day])->all();
                    foreach($dillers_calc as $diller_calc){
                        $new_loan_sum = $diller_calc->loan_sum + $diller_calc->old_loan_sum;
                        $new_diller_calc = DillersCalc::find()->where(['diller_id' => $diller_calc->diller_id,'day' => $new_day])->one();
                        if($new_diller_calc){
                            $new_diller_calc->given_sum = 0;
                            $new_diller_calc->loan_sum = 0;
                            $new_diller_calc->old_loan_sum = $new_loan_sum;
                            $new_diller_calc->all_sum = 0;
                            $new_diller_calc->day = $new_day;
                            $new_diller_calc->updated_at = $now;
                            $new_diller_calc->save(false);
                        }
                        else{
                            $new_diller_calc = new DillersCalc();
                            $new_diller_calc->diller_id = $diller_calc->diller_id;
                            $new_diller_calc->given_sum = 0;
                            $new_diller_calc->loan_sum = 0;
                            $new_diller_calc->old_loan_sum = $new_loan_sum;
                            $new_diller_calc->all_sum = 0;
                            $new_diller_calc->day = $new_day;
                            $new_diller_calc->created_at = $now;
                            $new_diller_calc->updated_at = $now;
                            $new_diller_calc->save(false);
                        }
                    }
                    $all_products = AllProducts::find()->where(['day'=>$old_day])->all();
                    foreach($all_products as $all_product){
                        $new_all_product = AllProducts::find()->where(['product_code' => $all_product->product_code,'day'=>$new_day])->one();
                        if($new_all_product){
                            $new_all_product->count = $all_product->count;
                            $new_all_product->updated_at = $now;
                            $new_all_product->save(false);
                        }
                        else{
                            $new_all_product = new AllProducts();
                            $new_all_product->product_code = $all_product->product_code;
                            $new_all_product->count = $all_product->count;
                            $new_all_product->day = $new_day;
                            $new_all_product->created_at = $now;
                            $new_all_product->updated_at = $now;
                            $new_all_product->save(false);
                        }
                    }
                    $kassa = Kassa::find()->where(['day' => $old_day])->one();
                    if($kassa){
                        $new_kassa = Kassa::find()->where(['day' => $new_day])->one();
                        if($new_kassa){
                            $new_kassa->old_day_sum = $kassa->sum;
                            $new_kassa->updated_at = $now;
                            $new_kassa->save(false);
                        }
                        else{
                            $new_kassa = new Kassa();
                            $new_kassa->day = $new_day;
                            $new_kassa->sum = 0;
                            $new_kassa->old_day_sum = $kassa->sum;
                            $new_kassa->created_at = $now;
                            $new_kassa->updated_at = $now;
                            $new_kassa->save(false);
                        }
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Days model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Days model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Days model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Days the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Days::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetModal()
    {
        $diller_id = $_POST['diller_id'];
        $products = Products::find()->where(['status' => true])->all();
        $str = "";
        $str .= "<table class='table table-bordered'>";
        $str .= "<tr>";
        $str .= "<th style=width:3%;' class='hor-center ver-middle'>#</th>";
        $str .= "<th  class='hor-center ver-middle'>Maxsulot nomi</th>";
        $str .= "<th style=width:10%;' class='hor-center ver-middle'>Narxi</th>";
        $str .= "<th style=width:10%;' class='hor-center ver-middle'>Olgan</th>";
        $str .= "<th style=width:10%;' class='hor-center ver-middle'>Qaytargan</th>";
        $str .= "<th style=width:10%;' class='hor-center ver-middle'>Jami</th>";
        $str .= "<th style=width:15%;' class='hor-center ver-middle'>Summa</th>";
        $str .= "</tr>";
        $n = 1;
        foreach ($products as $product) {
            $str .= "<tr>";
            $str .= "<td style=width:3%;' class='hor-center ver-middle'>" . $n . "</td>";
            $str .= "<td  class='hor-center ver-middle'>" . $product->name . "</td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'>" . $product->price->price . "</td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'><input name='buy[]' id='" . $product->code . "_" . $diller_id . "' type='number' step='0.1' min='0' class='form-control'/></td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'><input name='return[]' type='number' step='0.1' min='0' class='form-control'/></td>";
            $str .= "<td style=width:10%;' class='hor-center ver-middle'></td>";
            $str .= "<td style=width:15%;' class='hor-center ver-middle'></td>";
            $str .= "</tr>";
            $n++;
        }
        $str .= "</table>";
        echo $str;
        exit;
    }

    public function actionDillerView($id, $day_id)
    {
        $diller = Dillers::findOne($id);
        $day_model = Days::findOne($day_id);
        return $this->render('diller-view', [
            'diller' => $diller,
            'day_model' => $day_model,
        ]);
    }

    public function actionCheckCloseDay()
    {
        $day = $_POST['day'];

        $sql_diller_all_given = "SELECT sum(given_sum) all_given_sum from dillers_calc where day='" . $day . "'";
        $row_diller_all_given = Yii::$app->db->createCommand($sql_diller_all_given)->queryOne();
        $diller_all_given_sum = $row_diller_all_given['all_given_sum'];

        $sql_expense_all_given = "SELECT sum(given_sum) all_given_sum from expenses where day='" . $day . "'";
        $row_expense_all_given = Yii::$app->db->createCommand($sql_expense_all_given)->queryOne();
        $expense_all_given_sum = $row_expense_all_given['all_given_sum'];

        $sql_loan_all_given = "SELECT sum(given_sum) all_given_sum from loans_calc where day='" . $day . "'";
        $row_loan_all_given = Yii::$app->db->createCommand($sql_loan_all_given)->queryOne();
        $loan_all_given_sum = $row_loan_all_given['all_given_sum'];

        $sql_investment = "SELECT sum(sum) sum from investment where day='" . $day . "'";
        $row_investment = Yii::$app->db->createCommand($sql_investment)->queryOne();
        $investment_sum = $row_investment['sum'];

        $sql_investment = "SELECT sum(sum) sum from investment where day='" . $day . "'";
        $row_investment = Yii::$app->db->createCommand($sql_investment)->queryOne();
        $investment_sum = $row_investment['sum'];

        $kassa = Kassa::find()->where(['day' => $day])->one();
        $old_kassa = $kassa->old_day_sum;
        $now_kassa = $kassa->sum;

        $all_sum = $diller_all_given_sum + $investment_sum + $old_kassa;
        $all_minus_sum = $expense_all_given_sum + $loan_all_given_sum;
        $all_calc_sum = $all_sum - $all_minus_sum;
        $str = "";
        $str .= "<table class='table table-bordered table-sm'>";
        $str .= "<tr>";
        $str .= "<td>Bugun dillerlar bergan barcha pullar</td>";
        $str .= "<td>" . numberFormat($diller_all_given_sum, 0) . "</td>";
        $str .= "</tr>";
        $str .= "<tr>";
        $str .= "<td>Bugun xarajatga ishlatilgan barcha pullar</td>";
        $str .= "<td>" . numberFormat($expense_all_given_sum, 0) . "</td>";
        $str .= "</tr>";
        $str .= "<tr>";
        $str .= "<td>Bugun qarzlarga berilgan pullar</td>";
        $str .= "<td>" . numberFormat($loan_all_given_sum, 0) . "</td>";
        $str .= "</tr>";
        $str .= "<tr>";
        $str .= "<td>Investitsiya</td>";
        $str .= "<td>" . numberFormat($investment_sum, 0) . "</td>";
        $str .= "</tr>";
        $str .= "<tr>";
        $str .= "<td>Kechagi kassadagi pul</td>";
        $str .= "<td>" . numberFormat($old_kassa, 0) . "</td>";
        $str .= "</tr>";
        $str .= "<tr>";
        $str .= "<td>Hozirgi kassadagi pul</td>";
        $str .= "<td>" . numberFormat($now_kassa, 0) . "</td>";
        $str .= "</tr>";
        $str .= "</table>";
        $check = false;
        if ($all_calc_sum == $now_kassa) {
            $str .= "Barchasi to'g'ri, kunni yopishingiz mumkin.";
            $check = true;
        } elseif ($all_calc_sum < 0) {
            $str .= "Qo'lingizda mavjud bo'lgan summadan '" . $all_calc_sum . "' so'm ko'p miqdorda harajat va qarzga ishlatgansiz, xarajat va qarzlaringizni qaytadan tekshiring!!!";
        } elseif ($all_calc_sum > $now_kassa) {
            $diff = $all_calc_sum - $now_kassa;
            $str .= "Kassada <b>" . $diff . "</b> so'm pul kam!!!";
        } elseif ($all_calc_sum < $now_kassa) {
            $diff = $now_kassa - $all_calc_sum;
            $str .= "Kassada " . $diff . " so'm pul ko'p!!! Qayerdadir xato amaliyot bajargansiz, iltimos qaytadan tekshiring!!!";
        } else {
            $str .= "Protsess xato!!!";
        }
        if ($check) {
            $str .= "<br><br>" . Html::a("Kunni yopish", ['/milk/days/close-day', 'day' => $day], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Barcha xolatlarni tekshirib chiqdingizmi? Kun yopilgandan so\'ng shu kunga boshqa amaliyot bajara olmaysiz. Rozimisiz?',
                    'method' => 'post',
                ],
            ]);
        }
        echo $str;
        exit;
    }

    public function actionCloseDay($day)
    {
        $model = Days::find()->where(['day' => $day])->one();
        if ($model) {
            $model->status = false;
            $model->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}

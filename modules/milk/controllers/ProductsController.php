<?php

namespace app\modules\milk\controllers;

use app\modules\milk\models\AllMaterials;
use app\modules\milk\models\AllProducts;
use app\modules\milk\models\DailyMaterials;
use app\modules\milk\models\Days;
use app\modules\milk\models\DillersCalc;
use app\modules\milk\models\Expenses;
use app\modules\milk\models\ExpenseSpr;
use app\modules\milk\models\Investment;
use app\modules\milk\models\Kassa;
use app\modules\milk\models\Loans;
use app\modules\milk\models\LoansCalc;
use app\modules\milk\models\Productions;
use app\modules\milk\models\Products;
use app\modules\milk\models\ProductsSearch;
use app\modules\milk\models\Sellings;
use app\modules\milk\models\Prices;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
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
                        'save-production' => ['POST'],
                        'save-sellings' => ['POST'],
                        'save-expenses' => ['POST'],
                        'save-loans' => ['POST'],
                        'save-kassa' => ['POST'],
                        'save-invest' => ['POST'],
                        'save-materials' => ['POST'],
                    ],
                ],
            ]
        );
    }
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->orderBy(['ord' => SORT_ASC]);
        $xomashyos = ExpenseSpr::getXomashyos();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'xomashyos' => $xomashyos,
        ]);
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionCreate()
    {
        $model = new Products();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Products::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionSaveProduction()
    {
        if (!isset($_POST['product_code'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        $product_codes = $_POST['product_code'];
        $day = $_POST['day'];
        $now = date('Y-m-d H:i:s');
        $old_count_suzma = 0;
        $new_count_suzma = 0;
        $old_count_qaymoq_qoldiq = 0;
        $new_count_qaymoq_qoldiq = 0;
        foreach ($product_codes as $product_code) {
            $product = Products::find()->where(['code' => $product_code])->one();
            $expense_spr = ExpenseSpr::find()->where(['type' => 'xomashyo', 'code' => $product->expense_code])->one();
            $production = Productions::findOne($_POST['production_id'][$product_code]);
            if (isset($_POST['count'][$product_code])) {
                $count = $_POST['count'][$product_code];
                $delete = false;
                if ($production) {
                    $old_count = $production->count;
                    if ($product_code == 'suzma') {
                        $old_count_suzma = $old_count;
                        $new_count_suzma = $count;
                    }
                    if ($product_code == 'qaymoq_qoldiq') {
                        $old_count_qaymoq_qoldiq = $old_count;
                        $new_count_qaymoq_qoldiq = $count;
                    }
                    if ($count == 0) {
                        $production->delete();
                        $delete = true;
                    } else {
                        $production->count = $count;
                        $production->save(false);
                    }
                } else {
                    $old_count = 0;
                    if ($product_code == 'suzma') {
                        $old_count_suzma = $old_count;
                        $new_count_suzma = $count;
                    }
                    if ($product_code == 'qaymoq_qoldiq') {
                        $old_count_qaymoq_qoldiq = $old_count;
                        $new_count_qaymoq_qoldiq = $count;
                    }
                    if ($count != 0) {
                        $production = new Productions();
                        $production->product_code = $product_code;
                        $production->count = $count;
                        $production->day = $day;
                        $production->price = $_POST['price'][$product_code];
                        $production->created_at = $now;
                        $production->updated_at = $now;
                        $production->save(false);
                    }
                }
                $all_product = AllProducts::find()->where(['product_code' => $product_code, 'day' => $day])->one();
                if ($all_product) {
                    if (!$delete && $production) {
                        $diff_count = $production->count - $old_count;
                        $k = 'all_product and production have<br>production_count => ' . $production->count . '<br>diff =>' . $diff_count . "<br>old_count => " . $old_count;
                        $all_product_count = $all_product->count + $diff_count;
                        $all_product->count = $all_product_count;
                        $all_product->updated_at = $now;
                        $all_product->save(false);
                    } else {
                        $k = 'all_product have ' . $old_count;
                        $all_product_count = $all_product->count - $old_count;
                        $all_product->count = $all_product_count;
                        $all_product->updated_at = $now;
                        $all_product->save(false);
                    }
                } else {
                    if (!$delete) {
                        $k = 'production have ' . $old_count;
                        $all_product = new AllProducts();
                        $all_product->product_code = $product_code;
                        $all_product->count = $count;
                        $all_product->day = $day;
                        $all_product->created_at = $now;
                        $all_product->updated_at = $now;
                        $all_product->save(false);
                    } else {
                        $k = 'all_product and production not have ' . $old_count;
                    }
                }
                if ($expense_spr) {
                    $new_count = $count;
                    $daily_material = DailyMaterials::find()->where(['expense_code' => $expense_spr->code, 'day' => $day])->one();
                    if ($daily_material) {
                        $old_count = $daily_material->count;
                        if ($new_count == 0) {
                            $daily_material->delete();
                        } elseif ($old_count != $new_count) {
                            $daily_material->count = $new_count;
                            $daily_material->updated_at = $now;
                            $daily_material->save(false);
                        }
                    } else {
                        $old_count = 0;
                        $daily_material = new DailyMaterials();
                        $daily_material->expense_code = $expense_spr->code;
                        $daily_material->count = $new_count;
                        $daily_material->day = $day;
                        $daily_material->created_at = $now;
                        $daily_material->updated_at = $now;
                        $daily_material->save(false);
                    }
                    $all_material = AllMaterials::find()->where(['expense_code' => $expense_spr->code, 'day' => $day])->one();
                    if ($all_material) {
                        $new_all_count = $all_material->count + $old_count - $new_count;
                        $all_material->count = $new_all_count;
                        $all_material->updated_at = $now;
                        $all_material->save(false);
                    } else {
                        $all_material = new AllMaterials();
                        $all_material->expense_code = $expense_spr->code;
                        $all_material->count = $new_count;
                        $all_material->day = $day;
                        $all_material->created_at = $now;
                        $all_material->updated_at = $now;
                        $all_material->save(false);
                    }
                }
            } else {
                continue;
            }
            // debug($k);
        }
        ////////// SUZMA SMETANA ////////////////////////////
        $all_smetana_product = AllProducts::find()->where(['product_code' => 'smetana_20', 'day' => $day])->one();
        if ($all_smetana_product) {
            $new_smetana_count = $all_smetana_product->count + ($old_count_suzma * 13 / 10) - ($new_count_suzma * 13 / 10);
            if ($new_smetana_count > 0) {
                $all_smetana_product->count =  $new_smetana_count;
                $all_smetana_product->save(false);
            } else {
                $suzma_product = Productions::find()->where(['product_code' => 'suzma', 'day' => $day])->one();
                if ($suzma_product) {
                    $suzma_product->delete();
                }
            }
        } else {
            $suzma_product = Productions::find()->where(['product_code' => 'suzma', 'day' => $day])->one();
            if ($suzma_product) {
                $suzma_product->delete();
            }
        }
        ////////// SUZMA SMETANA ////////////////////////////
        ////////// QAYMOQ QAYMOQ_QOLDIQ ////////////////////////////
        $all_qaymoq_product = AllProducts::find()->where(['product_code' => 'qaymoq', 'day' => $day])->one();
        if ($all_qaymoq_product) {
            $new_qaymoq_count = $all_qaymoq_product->count + $old_count_qaymoq_qoldiq - $new_count_qaymoq_qoldiq;
            if ($new_qaymoq_count > 0) {
                $all_qaymoq_product->count =  $new_qaymoq_count;
                $all_qaymoq_product->save(false);
            } else {
                $qaymoq_qoldiq_product = Productions::find()->where(['product_code' => 'qaymoq_qoldiq', 'day' => $day])->one();
                if ($qaymoq_qoldiq_product) {
                    $qaymoq_qoldiq_product->delete();
                }
            }
        } else {
            $qaymoq_qoldiq_product = Productions::find()->where(['product_code' => 'qaymoq_qoldiq', 'day' => $day])->one();
            if ($qaymoq_qoldiq_product) {
                $qaymoq_qoldiq_product->delete();
            }
        }
        ////////// QAYMOQ QAYMOQ_QOLDIQ ////////////////////////////
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionSaveSellings()
    {
        $day = $_POST['day'];
        $now = date('Y-m-d H:i:s');
        if (!isset($_POST['product_code'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        $product_codes = $_POST['product_code'];
        $diller_id = $_POST['diller_id'];
        $old_loan_sum = $_POST['old_loan_sum'];
        $all_sum1 = 0;
        foreach ($product_codes as $product_code) {
            $selling_id = $_POST['selling_id'][$product_code];
            $price = $_POST['price'][$product_code];
            if (isset($_POST['buy'][$product_code])) {
                $buy = $_POST['buy'][$product_code];
                $return = $_POST['return'][$product_code];
                $last_buy = $buy - $return;
                $all_sum = $last_buy * $price;
                $all_sum1 += $all_sum;
                $selling = Sellings::find()->where(['id' => $selling_id])->one();
                $all_product = AllProducts::find()->where(['product_code' => $product_code, 'day' => $day])->one();
                if ($all_product) {
                    $diff = $all_product->count - $last_buy;
                    if ($selling) {
                        $last_buy = $buy - $return;
                        $last_selling_buy = $selling->buy - $selling->return;
                        $dif_last_buy = $last_buy - $last_selling_buy;
                        $diff = $all_product->count - $dif_last_buy;
                        $all_product->count = $diff;
                        $all_product->updated_at = $now;
                    } else {
                        $all_product->count = $diff;
                        $all_product->updated_at = $now;
                    }
                    if ($diff < 0) {
                        debug($product_code . " bazada yetarli emas!!!");
                    }
                    $all_product->save(false);
                }
                if ($selling) {
                    $selling->buy = $buy;
                    $selling->return = $return;
                    $selling->all_sum = $all_sum;
                    $selling->updated_at = $now;
                    $selling->save(false);
                } else {
                    $selling = new Sellings();
                    $selling->diller_id = $diller_id;
                    $selling->product_code = $product_code;
                    $selling->day = $day;
                    $selling->buy = $buy;
                    $selling->return = $return;
                    $selling->all_sum = $all_sum;
                    $selling->created_at = $now;
                    $selling->updated_at = $now;
                    $selling->save(false);
                }
            } else {
                continue;
            }
        }
        $given_sum = $all_sum1 == 0 ? 0 : $_POST['given_sum'];
        $loan_sum = $all_sum1 == 0 ? 0 : $all_sum1 - $given_sum;
        $diller_calc = DillersCalc::find()->where(['diller_id' => $diller_id, 'day' => $day])->one();
        if ($diller_calc) {
            $diller_calc->given_sum = $given_sum;
            $diller_calc->loan_sum = $loan_sum;
            $diller_calc->all_sum = $all_sum1;
            $diller_calc->updated_at = $now;
            $diller_calc->save(false);
        } else {
            $diller_calc = new DillersCalc();
            $diller_calc->diller_id = $diller_id;
            $diller_calc->given_sum = $given_sum;
            $diller_calc->loan_sum = $loan_sum;
            $diller_calc->old_loan_sum = $old_loan_sum;
            $diller_calc->all_sum = $all_sum1;
            $diller_calc->day = $day;
            $diller_calc->created_at = $now;
            $diller_calc->updated_at = $now;
            $diller_calc->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionSaveExpenses()
    {
        // debug($_POST);
        $day = $_POST['day'];
        $now = date('Y-m-d H:i:s');
        $arr_expense = [];
        foreach ($_POST['multipleinput'] as $key => $array) {
            $expense_code = $array['expense_code'];
            $expense_spr = ExpenseSpr::find()->where(['code' => $expense_code])->one();
            $type = $expense_spr->type;
            if (!in_array($expense_code, $arr_expense)) {
                $arr_expense[] = $expense_code;
                $new_count = $array['count'];
                $price = $array['price'];
                $given_sum = $array['given_sum'];
                $all_sum = $new_count * $price;
                $loan_sum = $all_sum - $given_sum;
                $expense = Expenses::find()->where(['expense_code' => $expense_code, 'day' => $day])->one();
                if ($expense) {
                    $old_count =  $expense->count;
                    if ($new_count == 0) {
                        $sql_loans_calc = "delete from loans_calc lc where lc.loan_id in (select l.id from loans l where l.expense_id=".$expense->id.")";
                        Yii::$app->db->createCommand($sql_loans_calc)->execute();
                        $sql_loans = "delete from loans l where l.expense_id=".$expense->id;
                        Yii::$app->db->createCommand($sql_loans)->execute();
                        $expense->delete();
                    } else {
                        $expense->sum = $price;
                        $expense->count = $new_count;
                        $expense->all_sum = $all_sum;
                        $expense->given_sum = $given_sum;
                        $expense->updated_at = $now;
                        $expense->save(false);
                    }
                } else {
                    $old_count = 0;
                    $expense = new Expenses();
                    $expense->expense_code = $expense_code;
                    $expense->sum = $price;
                    $expense->day = $day;
                    $expense->count = $new_count;
                    $expense->all_sum = $all_sum;
                    $expense->given_sum = $given_sum;
                    $expense->created_at = $now;
                    $expense->updated_at = $now;
                    $expense->save(false);
                }
                if ($type == 'xomashyo') {
                    $all_material = AllMaterials::find()->where(['expense_code' => $expense_code, 'day' => $day])->one();
                    if ($all_material) {
                        $new_all_count = $all_material->count - $old_count + $new_count;
                        $all_material->count = $new_all_count;
                        $all_material->updated_at = $now;
                        $all_material->save(false);
                    } else {
                        $all_material = new AllMaterials();
                        $all_material->expense_code = $expense_code;
                        $all_material->count = $new_count;
                        $all_material->day = $day;
                        $all_material->created_at = $now;
                        $all_material->updated_at = $now;
                        $all_material->save(false);
                    }
                } elseif ($type == 'product') {
                    $product_code = $expense_spr->product_code;
                    $production = Productions::find()->where(['product_code' => $product_code, 'day' => $day])->one();
                    if ($production) {
                        if ($new_count == 0) {
                            $production->delete();
                        } else {
                            $new_product_count = $production->count - $old_count + $new_count;
                            $production->count = $new_product_count;
                            $production->updated_at = $now;
                            $production->save(false);
                        }
                    } else {
                        $price_model = Prices::find()->where(['product_code' => $product_code, 'status' => true])->one();
                        $price = $price_model ? $price_model->price : 0;
                        $production = new Productions();
                        $production->product_code = $product_code;
                        $production->count = $new_count;
                        $production->day = $day;
                        $production->price = $price;
                        $production->created_at = $now;
                        $production->updated_at = $now;
                        $production->save(false);
                    }
                    $all_product = AllProducts::find()->where(['product_code' => $product_code, 'day' => $day])->one();
                    if($all_product){
                        $new_all_product_count = $all_product->count - $old_count + $new_count;
                        $all_product->count = $new_all_product_count;
                        $all_product->updated_at = $now;
                        $all_product->save(false);
                    }
                    else{
                        $all_product = new AllProducts();
                        $all_product->product_code = $product_code;
                        $all_product->count = $new_count;
                        $all_product->day = $day;
                        $all_product->created_at = $now;
                        $all_product->updated_at = $now;
                        $all_product->save(false);
                    }
                }
                $loan = Loans::find()->where(['expense_id' => $expense->id])->one();
                if ($loan) {
                    if ($loan_sum > 0) {
                        $loan->loan_sum = $loan_sum;
                        $loan->updated_at = $now;
                        $loan->save(false);
                    } elseif ($loan_sum == 0) {
                        foreach ($loan->loansCalcs as $loanCalcs) {
                            $loanCalcs->delete();
                        }
                        $loan->delete();
                    }
                } else {
                    if ($loan_sum > 0) {
                        $loan = new Loans();
                        $loan->expense_id = $expense->id;
                        $loan->loan_sum = $loan_sum;
                        $loan->created_at = $now;
                        $loan->updated_at = $now;
                        $loan->save(false);
                    }
                }
            } else {
                continue;
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionSaveLoans()
    {
        // debug($_POST);
        $day = $_POST['day'];
        if (!isset($_POST['given_sum'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        $all = $_POST['given_sum'];
        $now = date('Y-m-d H:i:s');
        foreach ($all as $loan_id => $given_sum) {
            if ($given_sum > 0) {
                $loans_calc = LoansCalc::find()->where(['loan_id' => $loan_id, 'day' => $day])->one();
                if ($loans_calc) {
                    $loans_calc->given_sum = $given_sum;
                    $loans_calc->updated_at = $now;
                    $loans_calc->save(false);
                } else {
                    $loans_calc = new LoansCalc();
                    $loans_calc->loan_id = $loan_id;
                    $loans_calc->given_sum = $given_sum;
                    $loans_calc->day = $day;
                    $loans_calc->created_at = $now;
                    $loans_calc->updated_at = $now;
                    $loans_calc->save(false);
                }
            } else {
                continue;
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionSaveKassa()
    {
        if (!isset($_POST['kassa'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        $kassa_sum = $_POST['kassa'];
        $now = date('Y-m-d H:i:s');
        $day = $_POST['day'];
        $kassa = Kassa::find()->where(['day' => $day])->one();
        if (!$kassa) {
            $kassa = new Kassa();
            $kassa->sum = $kassa_sum;
            $kassa->day = $day;
            $kassa->created_at = $now;
            $kassa->updated_at = $now;
            $kassa->save(false);
        } else {
            $kassa->sum = $kassa_sum;
            $kassa->updated_at = $now;
            $kassa->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionSaveInvest()
    {
        if (!isset($_POST['invest'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        $invest_sum = $_POST['invest'];
        $now = date('Y-m-d H:i:s');
        $day = $_POST['day'];
        $comment = $_POST['comment'];
        $invest = Investment::find()->where(['day' => $day])->one();
        if (!$invest) {
            $invest = new Investment();
            $invest->sum = $invest_sum;
            $invest->day = $day;
            $invest->comment = $comment;
            $invest->created_at = $now;
            $invest->updated_at = $now;
            $invest->save(false);
        } else {
            $invest->sum = $invest_sum;
            $invest->comment = $comment;
            $invest->updated_at = $now;
            $invest->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionSaveMaterials()
    {
        $day = $_POST['day'];
        $now = date('Y-m-d H:i:s');
        if (!isset($_POST['count'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        $counts = $_POST['count'];
        foreach ($counts as $expense_code => $new_count) {
            $daily_material = DailyMaterials::find()->where(['expense_code' => $expense_code, 'day' => $day])->one();
            if ($daily_material) {
                $old_count = $daily_material->count;
                $daily_material->count = $new_count;
                $daily_material->updated_at = $now;
                $daily_material->save(false);
            } else {
                $old_count = 0;
                $daily_material = new DailyMaterials();
                $daily_material->expense_code = $expense_code;
                $daily_material->count = $new_count;
                $daily_material->day = $day;
                $daily_material->created_at = $now;
                $daily_material->updated_at = $now;
                $daily_material->save(false);
            }
            $all_material = AllMaterials::find()->where(['expense_code' => $expense_code, 'day' => $day])->one();
            if ($all_material) {
                $all_new_count = $all_material->count + $old_count - $new_count;
                $all_material->count = $all_new_count;
                $all_material->updated_at = $now;
                $all_material->save(false);
            } else {
                $all_material = new AllMaterials();
                $all_material->expense_code = $expense_code;
                $all_material->count = $new_count;
                $all_material->day = $day;
                $all_material->created_at = $now;
                $all_material->updated_at = $now;
                $all_material->save(false);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}

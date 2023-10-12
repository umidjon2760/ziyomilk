<?php

namespace app\modules\milk\controllers;

use app\modules\milk\models\Days;
use app\modules\milk\models\DillersCalc;
use app\modules\milk\models\Productions;
use app\modules\milk\models\Products;
use app\modules\milk\models\ProductsSearch;
use app\modules\milk\models\Sellings;
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
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Products models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
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

    /**
     * Updates an existing Products model.
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
     * Deletes an existing Products model.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSaveProduction()
    {
        $product_codes = $_POST['product_code'];
        $day = Days::getOpenDay();
        $now = date('Y-m-d H:i:s');
        foreach ($product_codes as $product_code) {
            $production = Productions::findOne($_POST['production_id'][$product_code]);
            $count = $_POST['count'][$product_code];
            if ($production) {
                if ($count == 0) {
                    $production->delete();
                } else {
                    $production->count = $count;
                    $production->save(false);
                }
            } else {
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
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSaveSellings()
    {
        $day = Days::getOpenDay();
        $now = date('Y-m-d H:i:s');
        $product_codes = $_POST['product_code'];
        $diller_id = $_POST['diller_id'];
        $all_sum1 = 0;
        foreach ($product_codes as $product_code) {
            $selling_id = $_POST['selling_id'][$product_code];
            $price = $_POST['price'][$product_code];
            $buy = $_POST['buy'][$product_code];
            $return = $_POST['return'][$product_code];
            $all_sum = ($buy - $return) * $price;
            $all_sum1 += $all_sum;
            $selling = Sellings::find()->where(['id' => $selling_id])->one();
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
        }
        $given_sum = $all_sum1 == 0 ? 0 : $_POST['given_sum'];
        $loan_sum = $all_sum1 == 0 ? 0 : $all_sum1 - $given_sum;
        $diller_calc = DillersCalc::find()->where(['diller_id' => $diller_id, 'day' => $day])->one();
        if($diller_calc){
            $diller_calc->given_sum = $given_sum;
            $diller_calc->loan_sum = $loan_sum;
            $diller_calc->all_sum = $all_sum1;
            $diller_calc->updated_at = $now;
            $diller_calc->save(false);
        }
        else{
            $diller_calc = new DillersCalc();
            $diller_calc->diller_id = $diller_id;
            $diller_calc->given_sum = $given_sum;
            $diller_calc->loan_sum = $loan_sum;
            $diller_calc->all_sum = $all_sum1;
            $diller_calc->day = $day;
            $diller_calc->created_at = $now;
            $diller_calc->updated_at = $now;
            $diller_calc->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSaveExpenses(){
        debug($_POST);
    }
}

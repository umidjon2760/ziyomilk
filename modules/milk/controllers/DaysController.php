<?php

namespace app\modules\milk\controllers;

use app\modules\milk\models\Days;
use app\modules\milk\models\DaysSerach;
use app\modules\milk\models\Dillers;
use app\modules\milk\models\ExpenseSpr;
use app\modules\milk\models\Productions;
use app\modules\milk\models\Products;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
        $searchModel = new DaysSerach();
        $dataProvider = $searchModel->search($this->request->queryParams);

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
    public function actionView($id)
    {
        $day = $this->findModel($id);
        $products = Products::find()->where(['status' => true])->all();
        $dillers = Dillers::find()->where(['status' => true])->all();
        $expense_spr = ArrayHelper::map(ExpenseSpr::getAll(),'code','name');
        return $this->render('view', [
            'model' => $day,
            'products' => $products,
            'expense_spr' => $expense_spr,
            'dillers' => $dillers
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

    public function actionDillerView($id,$day_id)
    {
        $diller = Dillers::findOne($id);
        return $this->render('diller-view', [
            'diller' => $diller,
            'day_id' => $day_id,
        ]);
    }
}

<?php

namespace app\modules\milk\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "expense_spr".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Expenses[] $expenses
 */
class ExpenseSpr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense_spr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'unique'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code','type','product_code'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Kodi',
            'name' => 'Nomi',
            'type' => 'Turi',
            'product_code' => 'Maxsulot',
            'status' => 'Status',
            'created_at' => 'Yaratilgan vaqt',
            'updated_at' => 'O\'zgartirilgan vaqt',
        ];
    }

    /**
     * Gets query for [[Expenses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses()
    {
        return $this->hasMany(Expenses::class, ['expense_code' => 'code']);
    }

    public static function getAll()
    {
        $model = ExpenseSpr::find()->where(['status' => true])->orderBy(['type' => SORT_ASC])->all();
        return $model;
    }

    public static function getExpenseTypes(){
        return ['xarajat' => 'Xarajat', 'xomashyo' => 'Xomashyo','product' => 'Maxsulot'];
    }

    public static function getXomashyos(){
        $model = ExpenseSpr::find()->where(['status' => true,'type' => 'xomashyo'])->all();
        $items = ArrayHelper::map($model,'code','name');
        return $items;
    }

    public static function getProductCodes(){
        $model = ExpenseSpr::find()->select('product_code')->where(['status' => true,'type' => 'product'])->all();
        $items = ArrayHelper::getColumn($model,'product_code');
        return $items;
    }
}

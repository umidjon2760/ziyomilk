<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "daily_materials".
 *
 * @property int $id
 * @property string $expense_code
 * @property float|null $count
 * @property string|null $day
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Days $day0
 * @property ExpenseSpr $expenseCode
 */
class DailyMaterials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'daily_materials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expense_code'], 'required'],
            [['count'], 'number'],
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['expense_code'], 'string', 'max' => 50],
            [['day'], 'exist', 'skipOnError' => true, 'targetClass' => Days::class, 'targetAttribute' => ['day' => 'day']],
            [['expense_code'], 'exist', 'skipOnError' => true, 'targetClass' => ExpenseSpr::class, 'targetAttribute' => ['expense_code' => 'code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expense_code' => 'Expense Code',
            'count' => 'Count',
            'day' => 'Day',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Day0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDay0()
    {
        return $this->hasOne(Days::class, ['day' => 'day']);
    }

    /**
     * Gets query for [[ExpenseCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseCode()
    {
        return $this->hasOne(ExpenseSpr::class, ['code' => 'expense_code']);
    }
    

    public function getExpense($day)
    {
        $model = Expenses::find()->where(['expense_code' => $this->expense_code,'day'=>$day])->one();
        return $model;
    }
}

<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "expenses".
 *
 * @property int $id
 * @property string $expense_code
 * @property float|null $sum
 * @property string|null $day
 * @property int|null $count
 * @property float|null $all_sum
 * @property float|null $given_sum
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Days $day0
 * @property ExpenseSpr $expenseCode
 */
class Expenses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expenses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expense_code'], 'required'],
            [['sum', 'all_sum', 'given_sum'], 'number'],
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['count'], 'integer'],
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
            'sum' => 'Sum',
            'day' => 'Day',
            'count' => 'Count',
            'all_sum' => 'All Sum',
            'given_sum' => 'Given Sum',
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

    public function getLoan()
    {
        return $this->hasOne(Loans::class, ['expense_id' => 'id']);
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
}

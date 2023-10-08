<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "loans".
 *
 * @property int $id
 * @property int|null $expense_id
 * @property float|null $loan_sum
 * @property float|null $given_sum
 * @property string|null $day
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Days $day0
 * @property Expenses $expense
 */
class Loans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expense_id'], 'integer'],
            [['loan_sum', 'given_sum'], 'number'],
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['day'], 'exist', 'skipOnError' => true, 'targetClass' => Days::class, 'targetAttribute' => ['day' => 'day']],
            [['expense_id'], 'exist', 'skipOnError' => true, 'targetClass' => Expenses::class, 'targetAttribute' => ['expense_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expense_id' => 'Expense ID',
            'loan_sum' => 'Loan Sum',
            'given_sum' => 'Given Sum',
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
     * Gets query for [[Expense]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExpense()
    {
        return $this->hasOne(Expenses::class, ['id' => 'expense_id']);
    }
}

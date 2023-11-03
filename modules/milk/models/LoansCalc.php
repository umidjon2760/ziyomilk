<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "loans_calc".
 *
 * @property int $id
 * @property int|null $loan_id
 * @property float|null $given_sum
 * @property string|null $day
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Days $day0
 * @property Loans $loan
 */
class LoansCalc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loans_calc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_id'], 'integer'],
            [['given_sum'], 'number'],
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['day'], 'exist', 'skipOnError' => true, 'targetClass' => Days::class, 'targetAttribute' => ['day' => 'day']],
            [['loan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Loans::class, 'targetAttribute' => ['loan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loan_id' => 'Loan ID',
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
     * Gets query for [[Loan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoan()
    {
        return $this->hasOne(Loans::class, ['id' => 'loan_id']);
    }
}

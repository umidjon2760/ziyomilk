<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "dillers_calc".
 *
 * @property int $id
 * @property int $diller_id
 * @property float|null $given_sum
 * @property float|null $loan_sum
 * @property float|null $all_sum
 * @property string|null $day
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Days $day0
 */
class DillersCalc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dillers_calc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['diller_id'], 'required'],
            [['diller_id'], 'integer'],
            [['given_sum', 'loan_sum','old_loan_sum', 'all_sum'], 'number'],
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['day'], 'exist', 'skipOnError' => true, 'targetClass' => Days::class, 'targetAttribute' => ['day' => 'day']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'diller_id' => 'Diller ID',
            'given_sum' => 'Given Sum',
            'loan_sum' => 'Loan Sum',
            'old_loan_sum' => 'Old Loan Sum',
            'all_sum' => 'All Sum',
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
}

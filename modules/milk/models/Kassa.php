<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "kassa".
 *
 * @property int $id
 * @property string|null $day
 * @property float|null $sum
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Kassa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kassa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['sum'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => 'Day',
            'sum' => 'Sum',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

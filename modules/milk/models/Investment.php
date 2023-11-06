<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "investment".
 *
 * @property int $id
 * @property string|null $day
 * @property float|null $sum
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Investment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'investment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day','comment', 'created_at', 'updated_at'], 'safe'],
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
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

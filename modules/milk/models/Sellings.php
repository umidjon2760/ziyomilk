<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "sellings".
 *
 * @property int $id
 * @property int|null $diller_id
 * @property string $product_code
 * @property string|null $day
 * @property float|null $buy
 * @property float|null $return
 * @property float|null $all_sum
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Days $day0
 * @property Dillers $diller
 * @property Products $productCode
 */
class Sellings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sellings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['diller_id'], 'integer'],
            [['product_code'], 'required'],
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['buy', 'return', 'all_sum'], 'number'],
            [['product_code'], 'string', 'max' => 50],
            [['day'], 'exist', 'skipOnError' => true, 'targetClass' => Days::class, 'targetAttribute' => ['day' => 'day']],
            [['diller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dillers::class, 'targetAttribute' => ['diller_id' => 'id']],
            [['product_code'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_code' => 'code']],
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
            'product_code' => 'Product Code',
            'day' => 'Day',
            'buy' => 'Buy',
            'return' => 'Return',
            'all_sum' => 'All Sum',
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
     * Gets query for [[Diller]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiller()
    {
        return $this->hasOne(Dillers::class, ['id' => 'diller_id'])->where('dillers.status = true');
    }

    /**
     * Gets query for [[ProductCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCode()
    {
        return $this->hasOne(Products::class, ['code' => 'product_code']);
    }
}

<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "productions".
 *
 * @property int $id
 * @property string $product_code
 * @property int|null $count
 * @property string|null $day
 * @property float|null $price
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Days $day0
 * @property Products $productCode
 */
class Productions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_code'], 'required'],
            [['count'], 'integer'],
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['price'], 'number'],
            [['product_code'], 'string', 'max' => 50],
            [['day'], 'exist', 'skipOnError' => true, 'targetClass' => Days::class, 'targetAttribute' => ['day' => 'day']],
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
            'product_code' => 'Product Code',
            'count' => 'Count',
            'day' => 'Day',
            'price' => 'Price',
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
     * Gets query for [[ProductCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCode()
    {
        return $this->hasOne(Products::class, ['code' => 'product_code']);
    }
}

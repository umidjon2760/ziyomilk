<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "prices".
 *
 * @property int $id
 * @property string $product_code
 * @property float|null $price
 * @property int|null $status
 * @property string|null $photo
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Products $productCode
 */
class Prices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_code'], 'required'],
            [['price'], 'number'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_code'], 'string', 'max' => 50],
            [['photo'], 'string', 'max' => 255],
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
            'price' => 'Price',
            'status' => 'Status',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

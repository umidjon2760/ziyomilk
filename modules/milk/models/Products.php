<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property AllProducts[] $allProducts
 * @property Prices[] $prices
 * @property Productions[] $productions
 * @property Sellings[] $sellings
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['status'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Kodi',
            'name' => 'Nomi',
            'status' => 'Status',
            'created_at' => 'Yaratilgan vaqt',
            'updated_at' => 'O\'zgartirilgan vaqt',
        ];
    }

    /**
     * Gets query for [[AllProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAllProducts()
    {
        return $this->hasMany(AllProducts::class, ['product_code' => 'code']);
    }

    /**
     * Gets query for [[Prices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Prices::class, ['product_code' => 'code']);
    }

    /**
     * Gets query for [[Productions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductions()
    {
        return $this->hasMany(Productions::class, ['product_code' => 'code']);
    }

    /**
     * Gets query for [[Sellings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSellings()
    {
        return $this->hasMany(Sellings::class, ['product_code' => 'code']);
    }
}

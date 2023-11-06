<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "days".
 *
 * @property int $id
 * @property string|null $day
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property AllProducts[] $allProducts
 * @property DillersCalc[] $dillersCalcs
 * @property Expenses[] $expenses
 * @property Loans[] $loans
 * @property Productions[] $productions
 * @property Sellings[] $sellings
 */
class Days extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'days';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['day'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => 'Kun',
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
        return $this->hasMany(AllProducts::class, ['day' => 'day']);
    }

    /**
     * Gets query for [[DillersCalcs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDillersCalcs()
    {
        return $this->hasMany(DillersCalc::class, ['day' => 'day']);
    }

    /**
     * Gets query for [[Expenses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses()
    {
        return $this->hasMany(Expenses::class, ['day' => 'day']);
    }

    /**
     * Gets query for [[Loans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoans()
    {
        return $this->hasMany(Loans::class, ['day' => 'day']);
    }

    /**
     * Gets query for [[Productions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductions()
    {
        return $this->hasMany(Productions::class, ['day' => 'day']);
    }

    public function getKassa()
    {
        return $this->hasOne(Kassa::class, ['day' => 'day']);
    }
    public function getInvestment()
    {
        return $this->hasOne(Investment::class, ['day' => 'day']);
    }

    /**
     * Gets query for [[Sellings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSellings()
    {
        return $this->hasMany(Sellings::class, ['day' => 'day']);
    }

    public static function getOpenDay(){
        $day = Days::find()->where(['status' => true])->orderBy(['day' => SORT_DESC])->one();
        return $day ? $day->day : '2020-01-01';
    }
}

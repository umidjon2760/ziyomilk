<?php

namespace app\modules\milk\models;

use Yii;

/**
 * This is the model class for table "dillers".
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property int|null $phone
 * @property int|null $phone2
 * @property string|null $tg_address
 * @property string|null $car
 * @property string|null $car_number
 * @property string|null $photo
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Sellings[] $sellings
 */
class Dillers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dillers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['phone', 'phone2'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address', 'tg_address', 'photo'], 'string', 'max' => 255],
            [['car'], 'string', 'max' => 50],
            [['status'], 'boolean'],
            [['car_number'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ismi',
            'address' => 'Manzil',
            'phone' => 'Tel. raqam',
            'phone2' => 'Tel. raqam2',
            'tg_address' => 'Telegram',
            'car' => 'Moshina',
            'car_number' => 'Moshina raqami',
            'photo' => 'Rasm',
            'status' => 'Status',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'O\'zgartirilgan',
        ];
    }

    /**
     * Gets query for [[Sellings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSellings()
    {
        return $this->hasMany(Sellings::class, ['diller_id' => 'id'])->where('dillers.status = true');
    }

    public function getSelling($product_code, $day)
    {
        $model = Sellings::find()->where(['diller_id' => $this->id, 'product_code' => $product_code, 'day' => $day])->one();
        return $model;
    }

    public function getDillerCalc()
    {
        return $this->hasOne(DillersCalc::class, ['diller_id' => 'id']);
    }

    public function getDillerCalcByDay($day)
    {
        $model = DillersCalc::find()->where(['diller_id' => $this->id, 'day' => $day])->one();
        return $model;
    }

    public function getDillerCalcLastDay($day)
    {
        $day = date('Y-m-d', strtotime('-1 days', strtotime($day)));
        $model = DillersCalc::find()->where(['diller_id' => $this->id, 'day' => $day])->one();
        return $model;
    }
}

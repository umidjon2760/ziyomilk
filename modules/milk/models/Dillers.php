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
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'phone2' => 'Phone2',
            'tg_address' => 'Tg Address',
            'car' => 'Car',
            'car_number' => 'Car Number',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Sellings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSellings()
    {
        return $this->hasMany(Sellings::class, ['diller_id' => 'id']);
    }
}

<?php

namespace app\modules\room\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property integer $room_id
 * @property string $room_name
 * @property integer $building_id
 * @property double $longitude
 * @property double $latitude
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Building $building
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_name', 'building_id', 'created_by', 'updated_by'], 'required'],
            [['building_id', 'created_by', 'updated_by'], 'integer'],
            [['longitude', 'latitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['room_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'room_id' => Yii::t('app', 'Room ID'),
            'room_name' => Yii::t('app', 'Room Name'),
            'building_id' => Yii::t('app', 'Building'),
            'longitude' => Yii::t('app', 'Longitude'),
            'latitude' => Yii::t('app', 'Latitude'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasOne(\app\modules\building\models\Building::className(), ['building_id' => 'building_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['user_id' => 'updated_by']);
    }
}

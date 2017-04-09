<?php

namespace app\modules\classschedule\models;

use Yii;

/**
 * This is the model class for table "class_schedule_temporary".
 *
 * @property integer $class_schedule_id
 * @property string $start_date
 * @property string $start_time
 * @property string $end_date
 * @property string $end_time
 * @property integer $sun
 * @property integer $mon
 * @property integer $tue
 * @property integer $wed
 * @property integer $thu
 * @property integer $fri
 * @property integer $sat
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class ClassScheduleTemporary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'class_schedule_temporary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_schedule_id', 'start_time', 'end_time', 'created_by', 'updated_by'], 'required'],
            [['class_schedule_id', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'start_time', 'end_date', 'end_time', 'created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'class_schedule_id' => Yii::t('app', 'Class Schedule ID'),
            'start_date' => Yii::t('app', 'Start Date'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_date' => Yii::t('app', 'End Date'),
            'end_time' => Yii::t('app', 'End Time'),
            'sun' => Yii::t('app', 'Sun'),
            'mon' => Yii::t('app', 'Mon'),
            'tue' => Yii::t('app', 'Tue'),
            'wed' => Yii::t('app', 'Wed'),
            'thu' => Yii::t('app', 'Thu'),
            'fri' => Yii::t('app', 'Fri'),
            'sat' => Yii::t('app', 'Sat'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'updated_by']);
    }
}

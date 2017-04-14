<?php

namespace app\modules\semester\models;

use Yii;

/**
 * This is the model class for table "semester".
 *
 * @property integer $semester_id
 * @property string $semester_name
 * @property string $start_date
 * @property string $end_date
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_status
 *
 * @property ClassSchedule[] $classSchedules
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class Semester extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semester';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['semester_name', 'start_date', 'end_date', 'created_by', 'updated_by'], 'required'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_status'], 'integer'],
            [['semester_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'semester_id' => Yii::t('app', 'Semester ID'),
            'semester_name' => Yii::t('app', 'Semester Name'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_status' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassSchedules()
    {
        return $this->hasMany(ClassSchedule::className(), ['semester_id' => 'semester_id']);
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
<?php

namespace app\modules\subjects\models;

use Yii;

/**
 * This is the model class for table "subjects".
 *
 * @property integer $subject_id
 * @property string $subject_name
 * @property integer $status
 * @property integer $course_id
 * @property integer $batch_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property ClassSchedule[] $classSchedules
 * @property Courses $course
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Batches $batch
 */
class Subjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject_name', 'course_id', 'batch_id', 'created_by', 'updated_by'], 'required'],
            [['status', 'course_id', 'batch_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['subject_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subject_id' => Yii::t('app', 'Subject'),
            'subject_name' => Yii::t('app', 'Subject Name'),
            'status' => Yii::t('app', 'Status'),
            'course_id' => Yii::t('app', 'Course'),
            'batch_id' => Yii::t('app', 'Batch'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassSchedules()
    {
        return $this->hasMany(ClassSchedule::className(), ['subject_id' => 'subject_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(\app\modules\course\models\Courses::className(), ['course_id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\UserSearch::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\UserSearch::className(), ['user_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatch()
    {
        return $this->hasOne(\app\modules\course\models\Batches::className(), ['batch_id' => 'batch_id']);
    }
}

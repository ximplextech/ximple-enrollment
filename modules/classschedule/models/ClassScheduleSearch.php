<?php

namespace app\modules\classschedule\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\classschedule\models\ClassSchedule;

/**
 * ClassScheduleSearch represents the model behind the search form about `app\modules\classschedule\models\ClassSchedule`.
 */
class ClassScheduleSearch extends ClassSchedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_schedule_id', 'subject_id', 'school_year_id', 'semester_id', 'professor_id', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'created_by', 'updated_by', 'section_id', 'class_intake_limit'], 'integer'],
            [['start_time', 'end_time', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ClassSchedule::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'class_schedule_id' => $this->class_schedule_id,
            'subject_id' => $this->subject_id,
            'school_year_id' => $this->school_year_id,
            'semester_id' => $this->semester_id,
            'professor_id' => $this->professor_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'sun' => $this->sun,
            'mon' => $this->mon,
            'tue' => $this->tue,
            'wed' => $this->wed,
            'thu' => $this->thu,
            'fri' => $this->fri,
            'sat' => $this->sat,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'section_id' => $this->section_id,
            'class_intake_limit' => $this->class_intake_limit,
        ]);

        return $dataProvider;
    }
}

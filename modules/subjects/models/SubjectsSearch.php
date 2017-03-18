<?php

namespace app\modules\subjects\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\subjects\models\Subjects;

/**
 * SubjectsSearch represents the model behind the search form about `app\modules\subjects\models\Subjects`.
 */
class SubjectsSearch extends Subjects
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject_id', 'status', 'course_id', 'batch_id', 'created_by', 'updated_by'], 'integer'],
            [['subject_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = Subjects::find();

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
            'subject_id' => $this->subject_id,
            'status' => $this->status,
            'course_id' => $this->course_id,
            'batch_id' => $this->batch_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'subject_name', $this->subject_name]);

        return $dataProvider;
    }
}

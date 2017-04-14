<?php

namespace app\modules\semester\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\semester\models\Semester;

/**
 * SemesterSearch represents the model behind the search form about `app\modules\semester\models\Semester`.
 */
class SemesterSearch extends Semester
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['semester_id', 'created_by', 'updated_by', 'is_status'], 'integer'],
            [['semester_name', 'start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = Semester::find();

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
            'semester_id' => $this->semester_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_status' => $this->is_status,
        ]);

        $query->andFilterWhere(['like', 'semester_name', $this->semester_name]);

        return $dataProvider;
    }
}

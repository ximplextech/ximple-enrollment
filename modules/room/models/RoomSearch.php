<?php

namespace app\modules\room\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\room\models\Room;

/**
 * RoomSearch represents the model behind the search form about `app\modules\room\models\Room`.
 */
class RoomSearch extends Room
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_id', 'building_id', 'created_by', 'updated_by'], 'integer'],
            [['room_name', 'created_at', 'updated_at'], 'safe'],
            [['longitude', 'latitude'], 'number'],
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
        $query = Room::find();

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
            'room_id' => $this->room_id,
            'building_id' => $this->building_id,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'room_name', $this->room_name]);

        return $dataProvider;
    }
}

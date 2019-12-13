<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calendar;

/**
 * CalendarSearch represents the model behind the search form of `app\models\Calendar`.
 */
class CalendarSearch extends Calendar
{
    /**
     * {@inheritdoc}
     */
    public $start;
    public $end;
    public function rules()
    {
        return [
            [['id', 'start', 'end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function afterValidate()
    {
        $this->start = (integer) \Yii::$app->formatter->asTimestamp($this->start);
        $this->end = (integer) \Yii::$app->formatter->asTimestamp($this->end);

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
        $query = Calendar::find()
            ->joinWith('activity')
            ->andWhere(['calendar.used_id'=>\Yii::$app->user->id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere([
            'or',
                ['between', 'activity.started_at', $this->start, $this->end],
                ['between', 'activity.finished_at', $this->start, $this->end],
        ]);
        return $dataProvider;
    }
}

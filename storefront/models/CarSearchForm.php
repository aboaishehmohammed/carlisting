<?php
namespace storefront\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CarListing;

class CarSearchForm extends Model
{
    public $make;
    public $model;
    public $year_from;
    public $year_to;
    public $price_from;
    public $price_to;

    public function rules()
    {
        return [
            [['make', 'model'], 'string'],
            [['year_from', 'year_to', 'price_from', 'price_to'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = CarListing::find()->where(['status' => 'available']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'make', $this->make])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['>=', 'year', $this->year_from])
            ->andFilterWhere(['<=', 'year', $this->year_to])
            ->andFilterWhere(['>=', 'price', $this->price_from])
            ->andFilterWhere(['<=', 'price', $this->price_to]);

        return $dataProvider;
    }
}

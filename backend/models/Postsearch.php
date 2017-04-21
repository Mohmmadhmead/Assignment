<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\POST;

/**
 * Postsearch represents the model behind the search form about `app\models\POST`.
 */
class Postsearch extends POST
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category', 'owner'], 'integer'],
            [['title', 'description', 'date'], 'safe'],
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
    {$id= Yii::$app->user->identity->id;
    
$count = Yii::$app->db->createCommand('
    select * from post where owner=:id
', ['id'=>$id])->queryScalar();
$dataProvider = new ActiveDataProvider([
    'query' => Post::findBySql(" select * from post where owner=:id
", ['id'=>$id]),
    'pagination' => [
        'pageSize' => 10
    ],
]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        
        return $dataProvider;
    }
    
     public function deplication($params)
    {
  
$dataProvider = new ActiveDataProvider([
    'query' => Post::findBySql("select * from post where title in (SELECT title from post GROUP BY title having COUNT(*)>1) or description in (SELECT description from post GROUP BY description having COUNT(*)>1)"),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
      

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
   
        return $dataProvider;
    }
}

<?php

namespace backend\modules\order;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * models represents the model behind the search form about `common\models\Order`.
 */
class models extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id', 'user_id', 'status', 'admin_id'], 'integer'],
            [['create_date','send_date','create_date','user_id', 'status', 'admin_id'], 'safe'],
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
    public function search($params, $rstat = '')
    {
         $query = Order::find()->where('rstat <> 30');
        if(isset($rstat) && $rstat != ''){
             $query = Order::find()->where('rstat = 30');
        }
       
       // $query->where('send_date = :date',[':date'=>$this->send_date]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->orFilterWhere([
//            'id' => $this->id,
            'user_id' => $this->user_id,
            'create_date' => $this->create_date,
            'status' => $this->status,
            'admin_id' => $this->admin_id,
            'send_date'=>$this->send_date,
            'create_date'=>$this->create_date,
                              'update_date'=>$this->update_date
        ]);
        //$query->orFilterWhere(['between', 'send_date', $this->send_date, $this->send_date ]);
        //print_r($query);exit();

        return $dataProvider;
    }
}

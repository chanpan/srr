<?php
namespace frontend\modules\sections\controllers;
use yii\web\Controller;
use Yii; 
 
class CartController extends Controller
{
    public function actionMyCart(){        
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => Yii::$app->session["cart"],
            'sort' => [
                'attributes'=>['pro_name', 'pro_detail','pro_price', 'amount' , 'sum']
            ],
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        //\appxq\sdii\utils\VarDumper::dump(Yii::$app->session["cart"]);
        $breadcrumbs=[];
        $breadcrumbs_arr = [
            [
                'label' =>\Yii::t('cart', 'Home'), 
                'url' =>'/sections/session-management',
                'icon'=>'fa-home'
            ],
            [
                'label' => \Yii::t('cart', 'My Cart')
            ]
        ];
        foreach($breadcrumbs_arr as $key=>$v){
            $breadcrumbs[$key]=$v;
        } 
        $this->layout = "@frontend/themes/siriraj2/layouts/main-second"; 
//        \appxq\sdii\utils\VarDumper::dump($dataProvider);
        return $this->render('my-cart',[
           'dataProvider' => $dataProvider,
           'breadcrumb'=>$breadcrumbs,
           'count'=> count(Yii::$app->session["cart"])
        ]);
    }
    public function actionAddCart(){
        header('Access-Control-Allow-Origin: *');  
        $id     = Yii::$app->request->post("id","");
        $qty    = Yii::$app->request->post("qty","1");
        $size   = Yii::$app->request->post("size","");
        
        
        $id_arr = explode(',', $id);
        $data = [];
        foreach($id_arr as $v){
            $model = \common\models\Files::find()->where(["id"=>$v])->one();
            $data['id']   = $model->id;  
            $data['name'] = $model->file_name_org;
            $data['detail'] = $model->description;
            $data['price'] = 10;
            $data['image'] = $model->file_name_org;
            $data['size']=$size;
             
            \frontend\modules\sections\classes\JCart::addCart($v, $data, $qty, "add");
        }
        $count_cart = [
            'count'=>count(Yii::$app->session["cart"]),
            'res'=> Yii::$app->session["cart"]
        ];
        //\appxq\sdii\utils\VarDumper::dump($count_cart);
        return \janpan\jn\classes\JResponse::getSuccess(Yii::t('cart', 'Add cart success'), $count_cart, 'cart');
         
        //print_r(Yii::$app->session["cart"]);        return;
         
    }

    public function actionDeleteCart(){
        $data = \Yii::$app->session["cart"];
        $id = \Yii::$app->request->post('id', '');
        $out = [];
        
        foreach($data as $k=>$v){
            if($id == $k){
                \frontend\modules\sections\classes\JCart::addCart($id, $data, 1, 'del');
            }else{
               $out[$k] = $v;
            }
        }
        Yii::$app->session["cart"] = $out;
        return \janpan\jn\classes\JResponse::getSuccess("Delete successfully"); 
        
    }     
    
    public function actionMyCheckOut(){
        $step = Yii::$app->request->get('step');
        $user_id = Yii::$app->user->id;
        $breadcrumbs=[];
        $breadcrumbs_arr = [
            [
                'label' =>\Yii::t('cart', 'Home'), 
                'url' =>'/sections/session-management',
                'icon'=>'fa-home'
            ],
            [
                    'label' =>\Yii::t('cart', 'My Cart'),
                    'url' => [
                        0 => '/sections/cart/my-cart'
                        //'id' => '1'
                    ],                
                    'icon'=>'fa-shopping-cart'
            ],
            [
                'label' =>\Yii::t('cart', 'Checkout'),
            ],
        ];
        foreach($breadcrumbs_arr as $key=>$v){
            $breadcrumbs[$key]=$v;
        } 
        
        
        
        if($step == 1){  
            
            $order = new \common\models\Order();
            $order->id = time();//\appxq\sdii\utils\SDUtility::getMillisecTime();
            $order->create_date = new \yii\db\Expression('NOW()');
            $order->status = 1;
            $order->user_id = $user_id;
            if ($order->save()) {
                
                foreach (Yii::$app->session["cart"] as $key => $v) {
                    $order_detail = new \common\models\OrderDetail();
                    $order_detail->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                    $order_detail->order_id = $order->id;
                    $order_detail->product_id = $v['id'];
                    $order_detail->price = $v['sum'];
                    $order_detail->quantity = $v['amount'];
                    $order_detail->size = $v['size'];
                    //\appxq\sdii\utils\VarDumper::dump($order_detail);
                    if ($order_detail->save()) {
                        
                        //delete cart
                        \frontend\modules\sections\classes\JCart::addCart($v['id'], Yii::$app->session["cart"], 1, 'del');
                    }
                }
                Yii::$app->session["cart"] = [];
                return $this->redirect(['/sections/order/my-order']);
                
                //return $this->redirect(['/sections/order/my-order']);
                //return \janpan\jn\classes\JResponse::getSuccess("Successfully");
                //success
            }

            //end

            $model = \common\models\Shipper::find()->where(['user_id'=>$user_id])->one();
            \appxq\sdii\utils\VarDumper::dump($model);
            if(!$model){
                $model = new \common\models\Shipper();
                $model->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                
                $order = new \common\models\Order();
                $order->create_date = new \yii\db\Expression('NOW()');
                $order->status = 1;
                $order->user_id = $user_id;
                if ($order->save()) {
                    foreach (Yii::$app->session["cart"] as $key => $v) {
                        $order_detail = new \common\models\OrderDetail();
                        $order_detail->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                        $order_detail->order_id = $order->id;
                        $order_detail->product_id = $v['id'];
                        $order_detail->price = $v['sum'];
                        $order_detail->quantity = $v['amount'];
                        $order_detail->size = $v['size'];
                        if ($order_detail->save()) {
                            //delete cart
                            //\frontend\modules\sections\classes\JCart::addCart($v['id'], Yii::$app->session["cart"], 1, 'del');
                        }
                    }
                    //Yii::$app->session["cart"] = [];
                    //return $this->redirect(['/sections/order/my-order']);
                    return \janpan\jn\classes\JResponse::getSuccess("Successfully");
                    //success
                }
            }
            if($model->load(Yii::$app->request->post())){
                $model->user_id = $user_id; 
                if($model->validate() && $model->save()){
                       $order = \common\models\Order::find()->where(['user_id'=>$user_id])->one();
                       if($order){
                           return \janpan\jn\classes\JResponse::getSuccess("Successfully");
                       }
                       $order = new \common\models\Order();
                       $order->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                       $order->create_date = new \yii\db\Expression('NOW()');
                       $order->status = 1;
                       $order->user_id = $user_id;
                       if($order->save()){
                           foreach(Yii::$app->session["cart"] as $key=>$v){
                                $order_detail=new \common\models\OrderDetail();
                                $order_detail->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                                $order_detail->order_id = $order->id;
                                $order_detail->product_id = $v['id'];
                                $order_detail->price = $v['sum'];
                                $order_detail->quantity = $v['amount'];
                                $order_detail->size = $v['size'];
                                if($order_detail->save()){
                                    //delete cart
                                     \frontend\modules\sections\classes\JCart::addCart($v['id'], Yii::$app->session["cart"] , 1, 'del');
                                }
                            }
                            Yii::$app->session["cart"] = [];
                            return \janpan\jn\classes\JResponse::getSuccess("Successfully");
                            //success
                        } 
                }else{
                    return \janpan\jn\classes\JResponse::getError(\yii\helpers\Json::encode($model->errors));
                } 
            }
            $this->layout = "@frontend/themes/siriraj2/layouts/main-second";
            return $this->redirect(['/sections/order/my-order']);
            return $this->render('step1',[
                'model'=>$model,
                'breadcrumb'=>$breadcrumbs
            ]);
        }
        
    }
     
}

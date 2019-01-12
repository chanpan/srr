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
    
    
    public function getProduct($id){
        $orderDetail = \common\models\OrderDetail::find()->where(['order_id' => $id])->all();
        // \appxq\sdii\utils\VarDumper::dump($id);
        $file_arr = [];
        if ($orderDetail) {
            foreach ($orderDetail as $key => $o) {
                //\appxq\sdii\utils\VarDumper::dump($o->sizes->label);
                $files = \common\models\Files::find()->where(['id' => $o->product_id])->one();
                $file_arr[$key] = [
                'id' => isset($files->id) ? $files->id : '',
                'file_type' => isset($files->file_type) ? $files->file_type : '',
                'file_type_name' => isset($files->type->name) ? $files->type->name : '',
                'size' => isset($o->sizes->label) ? $o->sizes->label : '',
                'file_name_org' => isset($files->file_name_org) ? $files->file_name_org : '',
                'file_name' => isset($files->file_name) ? $files->file_name : '',
                'meta_text' => isset($files->meta_text) ? $files->meta_text : '',
                ];
            }
            sort($file_arr);
            // \appxq\sdii\utils\VarDumper::dump($files);
        }
        
        $product = "";
        $title = "";
        if ($file_arr) {
            $n = 1;
            $checkType = $this->groupByPartAndType($file_arr);
            foreach ($checkType as $c) {
                //$product .= "{$n}. ไฟล์ {$c['file_type_name']} เรื่อง ";
                $title .= "{$c['file_type_name']} / ";
                foreach ($file_arr as $key => $value) {
                    $meta_text = substr($value['file_name'], -4, 5);
                    if ($value['file_type'] == $c['file_type']) {
                        $product .= "<div class='f-t-11' style='margin-bottom:10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($key+1).". {$value['file_name_org']}</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>";
                    }
                    //$product .= "<span>{$key}</span>";
                    $n++;
                }
                
            }
        }
        return $product;
        //        \appxq\sdii\utils\VarDumper::dump($product);
    }
    public function groupByPartAndType($input) {
        $output = Array();
        
        foreach($input as $value) {
            $output_element = &$output[$value['file_type'] . "_" . $value['file_type']];
            $output_element['file_type'] = $value['file_type'];
            $output_element['file_type_name'] = $value['file_type_name'];
            $output_element['size'] = $value['size'];
            //!isset($output_element['file_type']) && $output_element['file_type'] = 0;
            //$output_element['count'] += $value['count'];
        }
        
        return array_values($output);
    }
    public function actionSaveRequest(){
        $order_id = Yii::$app->request->post('order_id', '');
        $model = new \common\models\Shipper();
       // \appxq\sdii\utils\VarDumper::dump($order_id);
        if($model->load(Yii::$app->request->post())){
            if($model->save()){
                $session = \Yii::$app->session;
                $session->remove('cart');
                return \janpan\jn\classes\JResponse::getSuccess("ส่งข้อมูลเรียบร้อย");
            }else{
                //return \janpan\jn\classes\JResponse::getError("error ", $model->errors);
            }
        }

        
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
            $order->rstat = '10';
            if ($order->save()) {
                
                foreach (Yii::$app->session["cart"] as $key => $v) {
                    $order_detail = new \common\models\OrderDetail();
                    $order_detail->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                    $order_detail->order_id = $order->id;
                    $order_detail->product_id = $v['id'];
                    $order_detail->price = $v['sum'];
                    $order_detail->quantity = $v['amount'];
                    $order_detail->size = $v['size'];
                    //$order_detail->rstat = '10';
                    //\appxq\sdii\utils\VarDumper::dump($order_detail);
                    if ($order_detail->save()) {
                        //if($order_id != ''){
                            //\frontend\modules\sections\classes\JCart::addCart($v['id'], Yii::$app->session["cart"], 1, 'del');
                        //}
                        //delete cart
                        //\frontend\modules\sections\classes\JCart::addCart($v['id'], Yii::$app->session["cart"], 1, 'del');
                    }else{
                        //\appxq\sdii\utils\VarDumper::dump($order_detail->errors);
                    }
                }
               // if($order_id != ''){
                   // Yii::$app->session["cart"] = [];
                //}
                //return $this->redirect(['/sections/order/my-order']);
                
                $id = $order->id;//Yii::$app->request->get('id', '');
                $user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : '';
                $model = \common\models\Shipper::find()->where('id=:id', [':id'=>$id])->one();
                if(!$model){
                    $model = new \common\models\Shipper();
                    $model->id = $id;
                }
                $product = $this->getProduct($id);
                if($model->load(Yii::$app->request->post())){
                    if($model->save()){
                        return \janpan\jn\classes\JResponse::getSuccess("ส่งข้อมูลเรียบร้อย");
                    }else{
                        return \janpan\jn\classes\JResponse::getError("error ", $model->errors);
                    }
                }
                //\appxq\sdii\utils\VarDumper::dump($model);
                return $this->render('add-request', [
                    'model'=>$model,
                    'product'=>$product,
                                     'order_id'=>$order->id
                    
                ]);
                
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

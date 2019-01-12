<?php
namespace frontend\modules\sections\controllers;
use yii\web\Controller;
use Yii; 
 
class OrderController extends Controller
{
    public function beforeAction($action)
    {
      $this->layout = "@frontend/themes/siriraj2/layouts/main-second"; 
      return parent::beforeAction($action);
    }
    public function actionMyOrder(){
        $user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : '';
        $model = \common\models\Order::find()->where(['user_id'=>$user_id]);
        
        $invoice = \common\models\Invoice::find()->where(['user_id'=>$user_id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $invoiceProvider = new \yii\data\ActiveDataProvider([
            'query' => $invoice,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
       // \appxq\sdii\utils\VarDumper::dump($dataProvider);

        $breadcrumbs=[];
        $breadcrumbs_arr = [
            [
                'label' => Yii::t('cart','Home'), 
                'url' =>'/sections/session-management',
                'icon'=>'fa-home'
            ],
            [
                    'label' =>Yii::t('appmenu','REQUEST INFORMATION'),
            ]
        ];
        foreach($breadcrumbs_arr as $key=>$v){
            $breadcrumbs[$key]=$v;
        } 
         
        return $this->render('my-order',[
           'dataProvider' => $dataProvider,
            'invoiceProvider'=>$invoiceProvider,
           'breadcrumb'=>$breadcrumbs,
            
        ]);
    }
    public function actionOrderDetail(){
        $order_id = Yii::$app->request->get('order_id', '');        
        $model = \common\models\OrderDetail::find()->where(['order_id'=>$order_id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        //\appxq\sdii\utils\VarDumper::dump($model->all());

        $breadcrumbs=[];
        $breadcrumbs_arr = [
            [
                'label' => Yii::t('section','Home'), 
                'url' =>'/sections/session-management',
                'icon'=>'fa-home'
            ],
            [
                    'label' => Yii::t('appmenu','My Orders'),
                    'url' => [
                        0 => '/sections/order/my-order'
                    ],                
                    'icon'=>'fa-shopping-cart'
            ],
            [
               'label' => Yii::t('order','Order Detail')
            ]
        ];
        foreach($breadcrumbs_arr as $key=>$v){
            $breadcrumbs[$key]=$v;
        } 
         
        return $this->render('order-detail',[
           'dataProvider' => $dataProvider,
           'breadcrumb'=>$breadcrumbs,
           //'order'=>$order
        ]);
    } 
    
    public function actionDeletOrder(){   
        $id = \Yii::$app->request->post('id', '');
        $order = \common\models\Order::find()->where(['id'=>$id])->one();
        if($order->delete()){
            $detail = \common\models\OrderDetail::find()->where(['order_id'=>$id])->all();
            foreach($detail as $d){
                $d->delete();
            }
            return \janpan\jn\classes\JResponse::getSuccess("Delete successfully"); 
        }else{
            return \janpan\jn\classes\JResponse::getError("Delete error"); 
        } 
    }   
    public function actionDeletOrderDetail(){    
        
        $id = \Yii::$app->request->post('id', '');
        $model = \common\models\OrderDetail::find()->where(['id'=>$id])->one();
        if($model->delete()){
            return \janpan\jn\classes\JResponse::getSuccess("Delete successfully"); 
        }else{
            return \janpan\jn\classes\JResponse::getError("Delete error"); 
        }        
    } 
    public function actionOrderInvoiceDetail(){
        $id     = \Yii::$app->request->get('id', '');
        $model  = \common\models\Invoice::findOne($id);
        if($model){
            $order  = \common\models\OrderDetail::find()->where(['order_id'=>$model->order_id])->all();           
            return $this->renderAjax('order-invoice-detail',[
                'model'=>$model,
                'order'=>$order
            ]);
        }
    }
    

     
    public function actionPrint(){
         
            $id = Yii::$app->request->get('id', '');
            $type = Yii::$app->request->get('type', '');
            $email = Yii::$app->request->get('email', '');
            
            $template = \backend\modules\cores\classes\CoreOption::getParams('form_request');
            $model = \common\models\Shipper::find()->where(['user_id'=> Yii::$app->user->id])->one();
            $orderDetail = \common\models\OrderDetail::find()->where(['order_id'=>$id])->all();
           // \appxq\sdii\utils\VarDumper::dump($id);
            $file_arr = [];
            if($orderDetail){
                foreach($orderDetail as $key=>$o){
                    //\appxq\sdii\utils\VarDumper::dump($o->sizes->label);
                    $files = \common\models\Files::find()->where(['id'=>$o->product_id])->one();
                    $file_arr[$key]=[
                        'id'=>isset($files->id)? $files->id : '', 
                        'file_type'=>isset($files->file_type) ? $files->file_type : '',
                        'file_type_name'=>isset($files->type->name) ? $files->type->name : '',
                        'size'=> isset($o->sizes->label) ? $o->sizes->label : '',
                        'file_name_org'=>isset($files->file_name_org) ? $files->file_name_org : '',
                        'file_name'=> isset($files->file_name) ? $files->file_name : '',
                        'meta_text'=> isset($files->meta_text) ? $files->meta_text : '',
                    ]; 
                    
                }
                sort($file_arr); 
               // \appxq\sdii\utils\VarDumper::dump($files);
            }
            
            $product = $this->getProduct($id);
            $title = "";
//            if($file_arr){
//                $n=1;
//                $checkType = $this->groupByPartAndType($file_arr);
//                foreach($checkType as $c){
//                    $product .= "{$n}. ไฟล์{$c['file_type_name']} เรื่อง ";
//                    $title .= "{$c['file_type_name']} / ";
//                    foreach($file_arr as $key=>$value){
//                        $meta_text = substr($value['file_name'], -4, 5);
//                        if($value['file_type'] == $c['file_type']){
//                            $product .= "<div style='margin-bottom:10px;'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- {$value['file_name_org']}</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>    
//                            </div>";
//                        }
//                    }
//                    $n++;
//                }
//            }
            $title = substr($title, 0, strlen($title)-2);
            //\appxq\sdii\utils\VarDumper::dump($x);
            if($type == "print"){
               return $this->renderAjax('print',[
                'template'=>$template,
                'model'=>$model,
                'count'=>count($orderDetail),
                'product'=>$product,
                 'title'=>$title,
                'autoPrint'=>true ,
                'id'=>$id   
              ]); 
            }else if($type == "preview"){
               return $this->renderAjax('preview',[
                'template'=>$template,
                'model'=>$model,
                'count'=>count($orderDetail),
                'product'=>$product,
                 'title'=>$title 
              ]); 
            }else{
                $content = $this->renderPartial('print',[
                    'template'=>$template,
                    'model'=>$model,
                    'count'=>count($orderDetail),
                    'product'=>$product,
                    'title'=>$title,
                    'id'=>$id
                     
                  ]); 
                if($email){
                    $layout = \kartik\mpdf\Pdf::ORIENT_PORTRAIT;
                    $paperSize = \kartik\mpdf\Pdf::FORMAT_A4;
                    $title  = "แบบฟอร์มคำร้องขอความอนุเคราะห์ไฟล์ ";  
                    $fileName = \yii\helpers\Url::to('@frontend/web/css/'.\appxq\sdii\utils\SDUtility::getMillisecTime().'.pdf');
                    \frontend\modules\sections\classes\JPrint::printPDF($layout, $paperSize, $title, $content, $fileName);
                }
                return $this->render('send-mail',[
                    'template'=>$template,
                    'model'=>$model,
                    'count'=>count($orderDetail),
                    'product'=>$product,
                    'title'=>$title,
                    'email'=>$email,
                    'fileName'=> isset($fileName) ? $fileName : ''
                ]);
            }
            
         
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
      
   public function actionAddRequest(){
       $id = Yii::$app->request->get('id', '');
       $user_id = Yii::$app->user->id;
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
       return $this->renderAjax('add-request', [
           'model'=>$model,
           'product'=>$product
       ]);
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
}

<?php

namespace backend\modules\order\controllers;

use Yii;
use common\models\Order;
use backend\modules\order\models;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * OrderManagementController implements the CRUD actions for Order model.
 */
class OrderManagementController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                //'only' => ['index'],
                'rules' => \backend\components\Rbac::getRbac(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
	if (parent::beforeAction($action)) {
	    if (in_array($action->id, array('create', 'update'))) {
		
	    }
	    return true;
	} else {
	    return false;
	}
    }
    
    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new models();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionGetUser()
    {
        $search=\Yii::$app->request->get('search', '');
        $out = ['more' => false];
       // \appxq\sdii\utils\VarDumper::dump($search);
        if (!is_null($search)) {
            
            $sql="SELECT u.id as id  , concat(p.firstname, ' ', p.lastname) as text FROM `user` as u INNER JOIN user_profile as p ON u.id=p.user_id WHERE concat(p.firstname, ' ', p.lastname) LIKE :search";
            $user = \Yii::$app->db->createCommand($sql,[':search'=>"%{$search['term']}%"])->queryAll();
            
            
            $out['results'] = array_values($user);
            
        }
        
        else {
            
            $out['results'] = ['ort' => '', 'text' => 'No matching records found'];
            
        }
        
        echo \yii\helpers\Json::encode($out);
    }
    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = \common\models\OrderDetail::find()->where(['order_id'=>$id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
	if (Yii::$app->getRequest()->isAjax) {
	    return $this->renderAjax('view', [
		'dataProvider' => $dataProvider,
                'model' => $model->one(),
	    ]);
	} else {
	    return $this->render('view', [
		'dataProvider' => $dataProvider,
                'model' => $model->one(),
	    ]);
	}
    }

    
    public function actionUpdate($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);

	    if ($model->load(Yii::$app->request->post())) {	
//                $invoice= \common\models\Invoice::find()->where(['order_id'=>$id])->one();
//                if(!$invoice){
//                    $invoice = new \common\models\Invoice();
//                    $invoice->id = 'INV'.\appxq\sdii\utils\SDUtility::getMillisecTime();
//                }
//                $invoice->order_id = $id;
//                $invoice->create_date = new \yii\db\Expression('NOW()');
//                $invoice->admin_id = Yii::$app->user->id;
//                $invoice->user_id = $model->user_id;
                $model->admin_id = Yii::$app->user->id;
                $model->send_date = new \yii\db\Expression('NOW()');
		if ($model->save()) {
//                    if($model->status != 1){
//                         $invoice->save();
//                    }                   
		   return \janpan\jn\classes\JResponse::getSuccess("Update successfully", $model);
		} else {
		   return \janpan\jn\classes\JResponse::getError("Update successfully"); 
		}
	    } else {
		return $this->renderAjax('update', [
		    'model' => $model,
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionViewDelete(){
        $searchModel = new models();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 3);
        
        return $this->render('view-delete', [
                             'searchModel' => $searchModel,
                             'dataProvider' => $dataProvider,
                             ]);
    }
    
    public function actionDelete($id)
    {
	//$id = \Yii::$app->request->post('id', '');
        $order = \common\models\Order::find()->where(['id'=>$id])->one();
        $order->rstat = 30;
        $order->update_date = date('Y-m-d');
        $order->admin_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : '';
        if($order->update()){
//            $detail = \common\models\OrderDetail::find()->where(['order_id'=>$id])->all();
//            foreach($detail as $d){
//                $d->delete();
//            }
            return \janpan\jn\classes\JResponse::getSuccess("Delete successfully");
        }else{
            return \janpan\jn\classes\JResponse::getError("Delete error"); 
        }
    }
    public function actionUnDelete($id)
    {
        //$id = \Yii::$app->request->post('id', '');
        $order = \common\models\Order::find()->where(['id'=>$id])->one();
        $order->rstat = 10;
        $order->update_date = date('Y-m-d');
        $order->admin_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : '';
        if($order->update()){
            //            $detail = \common\models\OrderDetail::find()->where(['order_id'=>$id])->all();
            //            foreach($detail as $d){
            //                $d->delete();
            //            }
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
    public function actionDownload(){
        $id = Yii::$app->request->get('id', '');
        $order = Order::findOne($id);
        $template = \backend\modules\cores\classes\CoreOption::getParams('form_request');

        
        //\appxq\sdii\utils\VarDumper::dump($order);
        
        $orderDetail = \common\models\OrderDetail::find()->where(['order_id' => $id])->all();
        $file_arr = [];
        if ($orderDetail) {
            foreach ($orderDetail as $key => $o) {
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
        }
        $product = $this->getProduct($id);
        $title = "";
//        if ($file_arr) {
//            $n = 1;
//            $checkType = $this->groupByPartAndType($file_arr);
//            foreach ($checkType as $c) {
//                $product .= "{$n}. ไฟล์{$c['file_type_name']} เรื่อง ";
//                $title .= "{$c['file_type_name']} / ";
//                foreach ($file_arr as $key => $value) {
//                    $meta_text = substr($value['file_name'], -4, 5);
//                    if ($value['file_type'] == $c['file_type']) {
//                        $product .= "<div style='margin-bottom:10px;'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- {$value['file_name_org']}</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>    
//                            </div>";
//                    }
//                }
//                $n++;
//            }
//        }
        
        $title = substr($title, 0, strlen($title) - 2);
        $content = $this->renderPartial('download', [
        'template' => $template,
        // 'model' => $model,
         'count' => count($orderDetail),
         'product' => $product,
         'title' => $title,
         'id'=>$id
        ]);
        $layout = \kartik\mpdf\Pdf::ORIENT_PORTRAIT;
        $paperSize = \kartik\mpdf\Pdf::FORMAT_A4;
        $title = "แบบฟอร์มคำร้องขอความอนุเคราะห์ไฟล์ ";
        
        $path = Yii::getAlias('@storage') . "/web/pdf";
        $name = \appxq\sdii\utils\SDUtility::getMillisecTime().'.pdf';
        
        $fileName = "{$path}/{$name}";
       \frontend\modules\sections\classes\JPrint::printPDF($layout, $paperSize, $title, $content, $fileName);
        $urlFile = \Yii::getAlias('@storageUrl');
       
        $data = ['filename'=>$name , 'path'=>"{$urlFile}/pdf/"];
        return \janpan\jn\classes\JResponse::getSuccess("Success", $data, 'download');

}
public function groupByPartAndType($input) {
        $output = Array();

        foreach ($input as $value) {
            $output_element = &$output[$value['file_type'] . "_" . $value['file_type']];
            $output_element['file_type'] = $value['file_type'];
            $output_element['file_type_name'] = $value['file_type_name'];
            $output_element['size'] = $value['size'];
            //!isset($output_element['file_type']) && $output_element['file_type'] = 0;
            //$output_element['count'] += $value['count'];
        }

        return array_values($output);
    }

    public function actionDeletes() {
	if (Yii::$app->getRequest()->isAjax) {
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    if (isset($_POST['selection'])) {
		foreach ($_POST['selection'] as $id) {
		    $this->findModel($id)->delete();
		}
		$result = [
		    'status' => 'success',
		    'action' => 'deletes',
		    'message' => SDHtml::getMsgSuccess() . Yii::t('app', 'Deleted completed.'),
		    'data' => $_POST['selection'],
		];
		return $result;
	    } else {
		$result = [
		    'status' => 'error',
		    'message' => SDHtml::getMsgError() . Yii::t('app', 'Can not delete the data.'),
		    'data' => $id,
		];
		return $result;
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    
    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
       // \appxq\sdii\utils\VarDumper::dump($dataProvider);

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
         
        return $this->renderAjax('order-detail',[
           'dataProvider' => $dataProvider,
           'breadcrumb'=>$breadcrumbs,
           //'order'=>$order
        ]);
    }
    
    public function actionViewRequest() {
        $id = Yii::$app->request->get('id', '');

        $template = \backend\modules\cores\classes\CoreOption::getParams('form_request');
        $model = \common\models\Shipper::find()->where(['user_id' => Yii::$app->user->id])->one();
        $orderDetail = \common\models\OrderDetail::find()->where(['order_id' => $id])->all();

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

        $product = $this->getProduct($id);
        $title = "";

        return $this->render('view-request', [
            'template' => $template,
            'model' => $model,
            'product' => $product,
            'id'=>$id,
            'count'=>count($orderDetail)
            
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

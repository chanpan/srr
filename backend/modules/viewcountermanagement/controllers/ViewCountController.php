<?php

namespace backend\modules\viewcountermanagement\controllers;

use Yii;
use common\models\View;
use backend\modules\viewcountermanagement\models\ViewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * ViewCountController implements the CRUD actions for View model.
 */
class ViewCountController extends Controller
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
     * Lists all View models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ViewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    
    public function actionPreview()
    {
 
        $print = Yii::$app->request->get('print', '');
        $month = Yii::$app->request->get('month', '');
        $year = Yii::$app->request->get('year', '');
        $start_date = "{$year}-{$month}-00";
        if($month == "00" || $month == ""){            
            $sql="
                SELECT 
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-01-01' AND '{$year}-01-31') as m1,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-02-01' AND '{$year}-02-31') as m2,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-03-01' AND '{$year}-03-31') as m3,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-04-01' AND '{$year}-04-31') as m4, 
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-05-01' AND '{$year}-05-31') as m5,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-06-01' AND '{$year}-06-31') as m6,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-07-01' AND '{$year}-07-31') as m7,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-08-01' AND '{$year}-08-31') as m8,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-09-01' AND '{$year}-09-31') as m9,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-10-01' AND '{$year}-10-31') as m10,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-11-01' AND '{$year}-11-31') as m11,
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-12-01' AND '{$year}-11-31') as m12  
              FROM tbl_view limit 1
            ";
            $data = Yii::$app->db->createCommand($sql)->queryOne();
             if(!$data){
                return "<div class='alert alert-danger'>ไม่พบข้อมูล</div>";
            }
            $datas = [$data['m1'],$data['m2'],$data['m3'],$data['m4'],$data['m5'],$data['m6'],$data['m7'],$data['m8'],$data['m9'],$data['m10'],$data['m11'],$data['m12']];
            $labels = \appxq\sdii\utils\SDdate::getMonthThAll();
            $labelFull = \appxq\sdii\utils\SDdate::getMonthFull();
            $output = "";
            $output .= "<h4>".Yii::t('section','Summarize')." ".Yii::t('section','Website Traffic Statistics')."</h4>";
            $output .= "<div class='table-responsive'>";
            $output .= "<table class='table table-bordered table-responsive'>";
            $output .= "<thead><tr><th>".Yii::t('section', 'Month')."</th><th style='width:150px;text-align:center;'>".Yii::t('section','Number of visitors/Person')."</th></tr></thead>";
            $total = 0;
            foreach($labelFull as $k=>$v){  
                $k=$k+1;
                $total += $data["m{$k}"];
                $output .= "
                    <tr>
                        <td>{$v}</td>
                        <td class='text-center'>{$data["m{$k}"]}</td>
                    </tr>                     
                "; 
            }
            $output .= "<tfoot>";
                $output .= "<tr>";
                    $output .= "<td style='font-weight: bold;'>";
                        $output .= \Yii::t('_app', 'Total');
                    $output .= "</td>";
                    $output .= "<td class='text-center;' style='font-weight: bold;text-align:center'>";
                        $output .= $total;
                    $output .= "</td>";
                $output .= "</tr>";
            $output .= "</tfoot>";
            $output .= "</table>";
            $output .= "</div>";
        }else{
            $labels = [\appxq\sdii\utils\SDdate::getMonthByKey($month-1)];
            $labelFull = \appxq\sdii\utils\SDdate::getMonthFullByKey($month-1);
            $output = "";
            if((int)$month < 10){
                $month = "0{$month}";
            }
            
            $sql="
                SELECT 
                (SELECT count(t1.id) FROM tbl_view as t1 WHERE t1.date BETWEEN '{$year}-00-01' AND '{$year}-$month-31') as m1
                FROM tbl_view limit 1
            ";
            $data = Yii::$app->db->createCommand($sql)->queryOne();
            $datas = [$data['m1']];
            $output .= "<h4>".Yii::t('section','Summarize')." ".Yii::t('section','Website Traffic Statistics')."</h4>";
            $output .= "เดือน <b>{$labelFull}</b> จำนวนผู้เข้าชม <b>{$data['m1']}</b> คน";
             
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels'=>$data
        ]);
        
        return $this->renderAjax('print', [ 
            'dataProvider' => $dataProvider,
            'print'=>$print,
            'labels'=>$labels,
            'datas'=>$datas,
            'output'=>$output
        ]);
    }
    
    public function actionReportDownload()
    { 
        return $this->render('report-download');
    }
    //report download
    public function actionReportDownloadPreview()
    {
 
        $print = Yii::$app->request->get('print', '');
        $month = Yii::$app->request->get('month', '');
        $year = Yii::$app->request->get('year', '');
        $start_date = "{$year}-{$month}-00";
        $output = [];
        if($month == "00" || $month == ""){
            $sql = "SELECT
                    t.id,t.user_id,		
                    MONTH(t.create_at) as months, 
                    YEAR(t.create_at) as years, 
                    SUM(t.count) as counts,
                    t.create_at
                FROM report_download as t 
                WHERE YEAR(t.create_at) = '{$year}'
                GROUP BY   t.user_id ,MONTH(t.create_at)";
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            if(!$data){
                return "<div class='alert alert-danger'>ไม่พบข้อมูล</div>";
            }
            $totalAll=0; 
//            \appxq\sdii\utils\VarDumper::dump($data); 
            $month = \appxq\sdii\utils\SDdate::getMonthFull();
            foreach ($month as $k => $v) {
                $output[$k + 1] = ['id' => $k + 1, 'name' => $v, 'data' => []];
                foreach ($data as $k2 => $v2) {
                    if ($v2['months'] == $k + 1) {
                        $totalAll += $v2['counts'];
                        $output[$k + 1]['totalAll'] = $totalAll;
                        array_push($output[$k + 1]['data'], $v2); 
                    }else{
                        $totalAll = 0;
                    }
                }
            }
           return $this->renderAjax('report-download-preview', [ 
                'output' => $output,
                'print'=>$print 
            ]);
        }else{
            $sql="
                SELECT *, sum(count) as counts FROM report_download 
                WHERE create_at BETWEEN '{$year}-{$month}-01' and '{$year}-{$month}-31' 
                GROUP BY user_id
            ";
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            if(!$data){
                return "<div class='alert alert-danger'>ไม่พบข้อมูล</div>";
            }
            $month = \appxq\sdii\utils\SDdate::getMonthFullByKey($month-1);
            //\appxq\sdii\utils\VarDumper::dump($data);
            return $this->renderAjax('report-download-preview-one', [ 
                'data' => $data,
                'month'=>$month,
                'print'=>$print 
            ]);
        }
        
        
        
    }
 
}

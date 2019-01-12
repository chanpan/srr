<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\ContactForm;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use backend\modules\sections\classes\JFiles;
use kartik\mpdf\Pdf;
/**
 * Class SiteController.
 */
class SiteController extends Controller
{
    
   
    public function beforeAction($action)
    {
      $this->layout = "@frontend/themes/siriraj2/layouts/main-second"; 
      return parent::beforeAction($action);
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
            'fileapi-upload' => [
                'class' => FileAPIUpload::class,
                'path' => '@storage/tmp',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionDocToImage()
    {
        $files = \common\models\Files::find()->where(['file_type'=>5])->all();
        $storageUrl = Yii::getAlias('@storage'); 
        $output = [];
        foreach($files as $key=>$file){
            $dir_path = $storageUrl."".$file['dir_path'];
            $fileName = $file['file_name'];
            $path = "{$dir_path}/{$fileName}";
            $fileNameArr = explode(".", $fileName); 
            $type = end($fileNameArr); 
            if ($type != "pdf") {
                    if ($type == "pptx" || $type == "ppt") {
                        if($type == "pptx"){
                            $description = JFiles::Pptx2Text($path, $fileName, $file, 'pptx');
                            $output['description'] = $description;
                            JFiles::PptxToPpt($path, $fileName, $file, 'pptx');
                        }else{
                            $description = JFiles::PptToPptx($path, $fileName, $file, 'ppt');
                            $output['description'] = $description; 
                        }
                    }else if($type == "docx" || $type == "doc"){
                        if($type == "docx"){
                            $description = JFiles::Docx2Text($path, $fileName, $file, 'docx');
                            $output['description'] = $description;
                        }else{
                            $description = JFiles::Doc2Docx($path, $fileName, $file, 'doc');
                            $output['description'] = $description; 
                        }
                    }else if($type == "xlsx" || $type == "xls"){ 
                        $description =  JFiles::Excel2Text("{$path}");
                        $output['description'] = $description; 
                    }else{
                        $output['description'] = "";
                    }
                     
                    JFiles::DocToPdf($path, "{$fileName}", $type);
                } else {
                    JFiles::PdfToJpg($path, "{$fileName}", $type);
                }
                \appxq\sdii\utils\VarDumper::dump($output);
        } 
    }
    public function actionIndex()
    {
        $files = \common\models\Files::find()->where(['file_type'=>3])->all();
        $storageUrl = Yii::getAlias('@storage');
        set_time_limit(1200);
        foreach($files as $key=>$file){
            $dir_path = $storageUrl."".$file['dir_path'];
            $fileName = $file['file_name'];
            $filePath = "{$dir_path}/{$fileName}";
            //\appxq\sdii\utils\VarDumper::dump($filePath);
            $template="ffmpeg -y -i {$filePath} -ss 00:00:02 -s 200x145 -vframes 1 {$filePath}_.jpg";
            exec($template, $output);
        }
        //\appxq\sdii\utils\VarDumper::dump($files);
        
        return $this->render('index');
    }
    public function actionAbout()
    {
        $about = \backend\modules\cores\classes\CoreOption::getParams("about", 'c');
        return $this->render('about',['about'=>$about]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $contact = \backend\modules\cores\classes\CoreOption::getParams("contact", 'c');
        return $this->render('contact',['contact'=>$contact]); 
    }
    public function actionDownloadFile(){
       if(\Yii::$app->user->isGuest){
            return '';
       }
       try {
           
           $model = new \common\models\ReportDownload();
           $model->count = 1;
           $model->user_id = \Yii::$app->user->id;
           $model->create_at = date('Y-m-d');
           $model->save();

            //get data files
           $id = \Yii::$app->request->get('id', '');
           $name = \Yii::$app->request->get('name', '');
           $type = \Yii::$app->request->get('type', '');
           $multi = \Yii::$app->request->get('multi', '');
           
           $file = \common\models\Files::findOne($id);
           $storageUrl = Yii::getAlias('@storage');
           $path = "{$storageUrl}{$file['dir_path']}/{$file['file_name']}";
           if($file['file_type'] == '2'){
               $filename = explode("_mark",$file['file_name']);
               $extensions = end($filename);
               if (\Yii::$app->user->can('admin') || \Yii::$app->user->can('administrator')) {
                   $path = "{$storageUrl}{$file['dir_path']}/thumbnail/{$filename[0]}_2124{$extensions}";
                   
               }else{
                   $path = "{$storageUrl}{$file['dir_path']}/thumbnail/{$filename[0]}_1024{$extensions}";
               }
           }
           
            $view = "{$file['file_path']}/{$file['file_name']}";
            
             $fn = $path;
            if ($fn) {
              //Perform security checks
              //.....check user session/role/whatever
              $result = $path;
              if (file_exists($result)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/force-download');
                header('Content-Disposition: attachment; filename='.basename($result));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($result));
                ob_clean();
                flush();
                readfile($result);
                //@unlink($result);
              }

            }
            //\appxq\sdii\utils\VarDumper::dump($path);
            
        } catch (\Exception $ex) {
            
        }
    }
    
    public function actionConvert(){
        
        if(\Yii::$app->user->isGuest){
            return '';
        }
        $model = new \common\models\ReportDownload();
         
        $model->count = 1;
        $model->user_id = \Yii::$app->user->id;
        $model->create_at = date('Y-m-d');
        $model->save();
        
        
        
        $id = \Yii::$app->request->get('id', '');
        $multi = \Yii::$app->request->get('multi', '');
        $file = \common\models\Files::findOne($id);
        
        $storageUrl = Yii::getAlias('@storage');
        $path = "{$storageUrl}{$file['dir_path']}/{$file['file_name']}";
        $view = "{$file['file_path']}/{$file['file_name']}";
        
        if(\Yii::$app->user->can('users')){
            $path = "{$storageUrl}{$file['dir_path']}/thumbnail/{$file['file_name']}";
            $view = "{$file['file_path']}/thumbnail/{$file['file_name']}";
        }
        
        $arr = ['5','7','8'];
        if(in_array($file['file_type'], $arr)){
            //\appxq\sdii\utils\VarDumper::dump($view);
            if($multi){
                $data = ['file_name'=>$file['file_name_org'], 'href'=>$view, 'type'=>$file['file_type']];
                return \janpan\jn\classes\JResponse::getSuccess("Success", $data);
            }
            return $view;
            
        }
        $img_file = $path;

            // Read image path, convert to base64 encoding
            $imgData = base64_encode(file_get_contents($img_file)); 
            $src = 'data:'.mime_content_type($img_file).';base64,'.$imgData;
            if($multi){
                $data = ['file_name'=>$file['file_name_org'], 'href'=>$src, 'type'=>$file['file_type']];
                return \janpan\jn\classes\JResponse::getSuccess("Success", $data);
            }
            
            
            return $src;
            //return $this->renderAjax("convert",['src'=>$src]);
        
    }
    public function getMemContentType($img_file){
        $result = new \finfo();
        
        if (is_resource($result) === true) {
            return $result->file($filename, FILEINFO_MIME_TYPE);
        }
        
        return false;
    }
    
    
    public function actionGetUrlFile(){
        
        if(\Yii::$app->user->isGuest){
            return '';
        }
        $model = new \common\models\ReportDownload();
         
        $model->count = 1;
        $model->user_id = \Yii::$app->user->id;
        $model->create_at = date('Y-m-d');
        $model->save();
        
        
        
        $id = \Yii::$app->request->get('id', '');
        $multi = \Yii::$app->request->get('multi', '');
        $file = \common\models\Files::findOne($id);
        
        $storageUrl = Yii::getAlias('@storage');
        $path = "{$storageUrl}{$file['dir_path']}/{$file['file_name']}";
        $view = "{$file['file_path']}/{$file['file_name']}";
         
        $data =[
            'path'=>$view,
            'name'=>$file['file_name_org']
        ];
        return \janpan\jn\classes\JResponse::getSuccess("Success", $data); 
        
    }
    
    /*pdf*/
    
    public function actionDocToPdf(){
       $id = \Yii::$app->request->post('id', '');
       $file = \common\models\Files::find()->where(['id'=>$id])->one();
       $dirPath = Yii::getAlias('@storage')."{$file['dir_path']}";
       $viewPath = "{$file['file_path']}";// storageUrl
       $folderName = "{$dirPath}/pdf";
       set_time_limit(1200);
       //$sql="libreoffice --headless --convert-to pdf:writer_pdf_Export {$dirPath}/{$file['file_name']}";       
       //$sql="export HOME=/var/www; /usr/bin/libreoffice --headless --convert-to pdf:writer_pdf_Export {$dirPath}/{$file['file_name']} --outdir {$dirPath}/{$file['file_name']}";
       $sql="export HOME=/var/www; /usr/bin/libreoffice --headless --convert-to pdf:writer_pdf_Export {$dirPath}/{$file['file_name']} --outdir {$dirPath}";  
       exec($sql, $output, $return_var);
       $fileNameArr = explode('.', $file['file_name']);
       if($return_var){            
            $data=[
                'id'=>$id,
                'path'=>"{$dirPath}/{$fileNameArr[0]}.pdf",
                'sql'=>$sql,
                'out'=>$output,
                'return_var'=>$return_var        
            ];
            return \janpan\jn\classes\JResponse::getSuccess("Success", $data);
       }else{
           $data=[
                'id'=>$id,
                'path'=>"{$dirPath}/{$fileNameArr[0]}.pdf",
                'sql'=>$sql,
                'out'=>$output,
                'return_var'=>$return_var        
            ];
            return \janpan\jn\classes\JResponse::getSuccess("Success", $data);
       }
    }
    public function actionCreateFile(){
      // echo \janpan\jn\widgets\SlideTop::widget([]);return; 
       $id = \Yii::$app->request->post('id', '');
       $path = \Yii::$app->request->post('path', '');
       
       $file = \common\models\Files::find()->where(['id'=>$id])->one();
       $dirPath = Yii::getAlias('@storage')."{$file['dir_path']}";
       $viewPath = "{$file['file_path']}";// storageUrl
       $folderName = "{$dirPath}/pdf";
       //1536390899000085100
       \backend\modules\sections\classes\JFiles::deleteDir("{$folderName}"); 
       $createDir=\backend\modules\sections\classes\JFiles::CreateDir("{$folderName}", false);
       if($createDir){
           set_time_limit(1200);
           $sql = "convert -density 500 {$dirPath}/{$file['file_name']} -quality 50 {$folderName}/preview.jpg";
           if($path){
                $sql = "convert -density 500 {$path} -quality 50 {$folderName}/preview.jpg";
           }           
           //\appxq\sdii\utils\VarDumper::dump($sql);
           exec($sql, $output, $return_var);
           if($return_var){
               return \janpan\jn\classes\JResponse::getSuccess("Success");
           }else{
               return \janpan\jn\classes\JResponse::getSuccess("Success");
           }
       }
       
    }
    public function actionViewFile(){
       $id = \Yii::$app->request->post('id', '');
       if($id==""){
            $id = \Yii::$app->request->get('id', '');
       }
       $file = \common\models\Files::find()->where(['id'=>$id])->one();
       
       $dirPath = Yii::getAlias('@storage')."{$file['dir_path']}";      
       $folderName = "{$dirPath}/pdf"; //c://xxxx
       $viewPath = "{$file['file_path']}/pdf";//http://www.xxx
        return $this->renderAjax('view-file',[
            'folderName'=>$folderName,
            'viewPath'=>$viewPath
        ]);
    }
    
    public function actionGetVideo(){
        $files = \common\models\Files::find()->where(['file_type'=>'3'])->all();
        foreach($files as $file) {
            $id             = $file['id'];
            $file_thumbnail = $file['file_thumbnail'];
            $file_name      = $file['file_name'];
            $dirPath        = Yii::getAlias('@storage')."{$file['dir_path']}";
            $videoFile      = "{$dirPath}/{$file_name}";
            if( $file_thumbnail == "" ){
                $file_thumbnail = \appxq\sdii\utils\SDUtility::getMillisecTime()."_mark.mp4";
            }
            $imageFile      = explode(".", $file_thumbnail);
            $imageFile      = "{$dirPath}/{$imageFile[0]}.jpg";
            //\appxq\sdii\utils\VarDumper::dump($videoFile);
            \backend\modules\sections\classes\JFiles::getThumbVideo($videoFile, '00:00:05', '200x160', $imageFile);
            \appxq\sdii\utils\VarDumper::dump($id);
        }
        
    }
    
    public function actionPdf(){
//        $content = $this->renderPartial('pdf', [
//            
//        ]);
        
        $layout = Pdf::ORIENT_PORTRAIT;
        $paperSize = Pdf::FORMAT_A4;
        $title  = "ทดสอบ PDF";
        $content = "<h1>ทดสอบ PDF 55555 >Submit</button></h1>";
        $fileName = \yii\helpers\Url::to('@frontend/web/css/test12.pdf');
        \frontend\modules\sections\classes\JPrint::printPDF($layout, $paperSize, $title, $content, $fileName);
    }
    
    public function actionTopSearch(){
      return $this->renderAjax('top-search');   
    }
    public function actionHighlight(){
      return $this->renderAjax('highlight');   
    }
    
    public function actionDemo()
    {
        
//        $section = \common\models\Sections::find()->where(['rstat' => 3])->all();
//        foreach ($section as $s) {
//            \backend\modules\sections\classes\CNParent::deleteSection($s['id']);
//        }
        
        $content = \common\models\Contents::find()->where('rstat = 3')->all();
        foreach($content as $c){
            $files = \common\models\Files::find()->where(['content_id'=>$c['id']])->all();
            foreach($files as $f){
                $f->rstat = 3;
                $f->update();
            }
        }
        \appxq\sdii\utils\VarDumper::dump('success');
    }
    public function actionAlert()
    {
        return $this->renderAjax('alert');
    }
}

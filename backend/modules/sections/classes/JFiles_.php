<?php

namespace backend\modules\sections\classes;

use appxq\sdii\utils\SDUtility;
use yii\db\Exception;
use yii\helpers\BaseFileHelper;
use Yii;

class JFiles_ {

    public static function getTypeFile() {
        $type = \common\models\FileType::find()->all();
        if ($type) {
            return $type;
        }
    }

    /**
     * 
     * @param type $model model files
     * @param type $fileName filename generator
     * @param type $content_id content id
     * @param type $path @storageUrl/images/...
     * @param type $defaultFile default filename
     * @param type $file array type , size ?
     */
    public static function Save($model, $fileName, $content_id, $path, $defaultFile, $file, $dir_path = '', $file_view = "", $detail_meta = "", $description="", $require_file='', $file_thumbnail='') {
        try {
            $meta = [];
            if (!empty($file->type)) {
                $meta['type'] = $file->type;
            }
            if (!empty($file->size)) {
                $meta['size'] = $file->size;
            }

            $files = new \common\models\Files();
            $files->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
            $files->name = $fileName;
            $files->description = "";
            $files->rstat = 1;
            $files->file_name = $fileName;
            $files->file_thumbnail = $fileName;
            $files->file_name_org = $defaultFile;
            $files->content_id = $content_id;
            $files->user_create = \Yii::$app->user->id;
            $files->create_date = new \yii\db\Expression('NOW()');
            $files->file_path = $path;
            $files->file_type = $model->file_type;
            $files->meta_text = SDUtility::array2String($meta);
            $files->dir_path = $dir_path;
            $files->file_view = $file_view;
            $files->detail_meta = $detail_meta;
            $files->description = $description;
            $files->require_files = $require_file;
            $files->file_thumbnail = $file_thumbnail;
            if ($files->save()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $path Yii::getAlias('@storage') . "/web/images/{$folderName}";
     * @return type boolean true or false
     */
    public static function CreateDir($path, $thum = true) {
        if ($path != NULL) {
            if (BaseFileHelper::createDirectory($path, 0777, true)) {
                if ($thum) {
                    BaseFileHelper::createDirectory($path . '/thumbnail', 0777, true);
                }

                return TRUE;
            }
        }
        return FALSE;
    }

    
    /**
     * 
     * @param type $file UploadedFile::getInstancesByName('name')
     * @param type $filePath /var/www/xx
     * @param string $fileType /obj
     * @param type $thumbnail 
     * @param type $watermark /model
     * @return boolean
     */
    public static function uploadImage($file, $filePath, $fileType, $thumbnail, $watermark) {
        try {
            $default_type = ['jpg', 'png', 'gif', 'jpeg'];
            $type = "";
            $sql = "";
            $mark = Yii::getAlias('@storage') . "/web/{$watermark['path']}/{$watermark['name']}";

            $output = [];
            //\appxq\sdii\utils\VarDumper::dump($output);
            // เช็คประเภทไฟล์ 
            if (in_array($fileType[1], $default_type)) {
                if ($fileType[1] == "jpeg") {
                    $fileType[1] = "jpg";
                }
                if ($file->saveAs("{$filePath}.{$fileType[1]}")) {
                    $type = $fileType[1];
                    set_time_limit(1200);
                    $modelForm = ['filename' => "{$filePath}.{$fileType[1]}", 'mark' => $mark, 'target' => "{$filePath}_mark.{$fileType[1]}"];
                    $template = self::getTemplateMark($modelForm, $watermark['code']);
                    $sql = "magick convert {$filePath}_mark.{$fileType[1]} -resize 1024x768 {$thumbnail}_mark.{$fileType[1]}";
                    $sql2 = "magick convert {$filePath}.{$fileType[1]} -resize 200x200 {$thumbnail}_preview.jpg";
                    //2124x1414 
                    
                    @exec($template . " && " . $sql . " && " . $sql2, $out, $retval);

                    exec("stat {$filePath}.{$fileType[1]}", $des1);
                    exec("file {$filePath}.{$fileType[1]}", $des2);

                    //original file
                    $sql10 = "magick convert {$filePath}.{$fileType[1]} -resize 2124x1414 {$thumbnail}_2124.{$fileType[1]}";
                    $sql11 = "magick convert {$filePath}.{$fileType[1]} -resize 1024x768 {$thumbnail}_1024.{$fileType[1]}";
                    @exec($sql10 . " && " . $sql11, $out, $retval);
                    
                    @unlink("{$filePath}.{$fileType[1]}");
                    //return ["type"=>$type];
                    $output['detai'] = \yii\helpers\Json::encode($des1) . \yii\helpers\Json::encode($des2);
                    $output['type'] = $type;

                    return $output;
                    //\appxq\sdii\utils\VarDumper::dump($output);
                    //$wm = "magick convert {$filePath}.{$fileType[1]} -resize 1024x768 -gravity SouthEast {$mark} -geometry +20+20  -composite {$filePath}.{$fileType[1]}";
                }
            } else {
                if ($file->saveAs("{$filePath}.{$fileType[1]}")) {
                    $type = "jpg";

                    $sql = "magick convert {$filePath}.{$fileType[1]} -resize 1024x768 {$thumbnail}_mark.jpg";
                    $modelForm = ['filename' => "{$filePath}.{$fileType[1]}", 'mark' => $mark, 'target' => "{$filePath}_mark.jpg"];
                    $template = self::getTemplateMark($modelForm, $watermark['code']);
                    set_time_limit(1200);
                    $sql2 = "convert {$filePath}_mark.jpg -resize 200x200 {$thumbnail}_preview.jpg";
                    @exec($template . " && " . $sql . " && " . $sql2, $out, $retval);
                    //exec($template." && ".$sql, $out, $retval);

                    exec("stat {$filePath}.{$fileType[1]}", $des1);
                    exec("file {$filePath}.{$fileType[1]}", $des2);
                    
                    
                    //original file
                    $sql10 = "magick convert {$filePath}.{$fileType[1]} -resize 2124x1414 {$thumbnail}_2124.{$fileType[1]}";
                    $sql11 = "magick convert {$filePath}.{$fileType[1]} -resize 1024x768 {$thumbnail}_1024.{$fileType[1]}";
                    @exec($sql10 . " && " . $sql11, $out, $retval);

                    @unlink("{$filePath}.{$fileType[1]}");
                    //return ["type"=>$type];
                    $output['detai'] = \yii\helpers\Json::encode($des1) . \yii\helpers\Json::encode($des2);
                    $output['type'] = $type;

                    return $output;
                }
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * 
     * @param type $model model files
     * @param type $images UploadedFile::getInstancesByName('name')
     * @param type $content_id content id
     * @param $folderName folder name
     * @return boolean
     */
    public static function uploadDocx($file, $filePath = "", $path = "", $fileName = "") {
        $output = [];
        if ($file->saveAs("{$filePath}.{$file->extension}")) {//save image
            exec("stat {$filePath}.{$file->extension}", $des1);
            exec("file {$filePath}.{$file->extension}", $des2);
            $output['detai'] = \yii\helpers\Json::encode($des1) . \yii\helpers\Json::encode($des2);

            if ($file) {
                $fileNameArr = explode(".", $file->name);
                $type = end($fileNameArr);
                if ($type != "pdf") {
                    if ($type == "pptx" || $type == "ppt") {
                        if($type == "pptx"){
                            $description = self::Pptx2Text($path, $fileName, $file);
                            $output['description'] = $description;
                            self::PptxToPpt($path, $fileName, $file);
                        }else{
                            $description = self::PptToPptx($path, $fileName, $file);
                            $output['description'] = $description; 
                        }
                    }else if($type == "docx" || $type == "doc"){
                        if($type == "docx"){
                            $description = self::Docx2Text($path, $fileName, $file);
                            $output['description'] = $description;
                        }else{
                            $description = self::Doc2Docx($path, $fileName, $file);
                            $output['description'] = $description; 
                        }
                    }else if($type == "xlsx" || $type == "xls"){ 
                        $description =  self::Excel2Text("{$filePath}.{$file->extension}");
                        $output['description'] = $description; 
                    }else{
                        $output['description'] = "";
                    }
                     
                    self::DocToPdf($path, "{$fileName}.{$file->extension}", $type);
                } else {
                    self::PdfToJpg($path, "{$fileName}.{$file->extension}", $type);
                }
            }
            $output['type'] = $file->extension;
        }

        return $output;
    }
    public static function Docx2Text($path, $fileName, $file, $type=""){        
        if($type != ""){
            $type = $type;
        }else{
            $type = "{$file->extension}";
        }
        $sql="/usr/bin/docx2txt {$path}/{$fileName}.{$type}";
        exec($sql, $o);        
       
        $str = "";
        $data=file("{$path}/{$fileName}.txt");  // ข้อมูลที่ได้จากการใช้ Function file() จะได้ออกมาเป็น Array แต่ละบัีนทัดข้อมูลที่เก็บใน File คือ 1 ค่า index ของ Array
        for($i=0;$i<count($data);$i++){  // วนรอบเพื่อแสดงผลขอ้มูล
            $str .= $data[$i];
        }  
        return $str;
         
    }
    
    public static function Doc2Docx($path, $fileName, $file, $type="") {
//        $type = "{$file->extension}";
        if($type != ""){
            $type = $type;
        }else{
            $type = "{$file->extension}";
        }
        set_time_limit(1200);
        $sql = "export HOME=/var/www; /usr/bin/libreoffice --headless --convert-to docx {$path}/{$fileName}.{$type} --outdir {$path}";
        exec($sql, $output, $return_var); 
        //$result = exec("catppt {$path}/{$fileName}.ptt", $detail); 
        $description = self::Docx2Text($path, $fileName, $file, 'docx');
        return $description;
        
    }
    public static function Excel2Text($file) {
        try{
           // $file = Yii::getAlias('@webroot').'/'.$model->uploadPath.'/'.$model->file;
            $inputFile = \PHPExcel_IOFactory::identify($file);
            $objReader = \PHPExcel_IOFactory::createReader($inputFile);
            $objPHPExcel = $objReader->load($file);
        }catch (Exception $e){
            Yii::$app->session->addFlash('error', 'เกิดข้อผิดพลาด'. $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $objWorksheet = $objPHPExcel->getActiveSheet();

        foreach($objWorksheet->getRowIterator() as $rowIndex => $row){
            $arr[] = $objWorksheet->rangeToArray('A'.$rowIndex.':'.$highestColumn.$rowIndex);
        }
        $arr = \yii\helpers\Json::encode($arr);
        return $arr;
    }
     

    public static function PptToPptx($path, $fileName, $file, $type = "") {
        //$type = "{$file->extension}";
        if($type != ""){
            $type = $type;
        }else{
            $type = "{$file->extension}";
        }
        set_time_limit(1200);
        $sql = "export HOME=/var/www; /usr/bin/libreoffice --headless --convert-to pptx {$path}/{$fileName}.{$type} --outdir {$path}";
        exec($sql, $output, $return_var); 
        //$result = exec("catppt {$path}/{$fileName}.ptt", $detail); 
        $description = self::Pptx2Text($path, $fileName, $file, 'pptx');
        return $description;
    }
    
    public static function Pptx2Text($path, $fileName, $file, $type=""){        
        if($type != ""){
            $type = $type;
        }else{
            $type = "{$file->extension}";
        }
        $sql="/usr/bin/pptx2text {$path}/{$fileName}.{$type}";
        exec($sql, $output);
        return \yii\helpers\Json::encode($output);
         
    }

    //pptx to ppt
    public static function PptxToPpt($path, $fileName, $file, $type="") {
        //$type = "{$file->extension}";
        if($type != ""){
            $type = $type;
        }else{
            $type = "{$file->extension}";
        }
        set_time_limit(1200);
        $sql = "export HOME=/var/www; /usr/bin/libreoffice --headless --convert-to ppt {$path}/{$fileName}.{$type} --outdir {$path}";
        exec($sql, $output, $return_var);

        $result = exec("catppt {$path}/{$fileName}.ptt", $detail);
        //\appxq\sdii\utils\VarDumper::dump($detail);
    }

    public static function DocToPdf($path, $fileName, $type = "") {
        $dirPath = Yii::getAlias('@storage') . "{$path}";
        $viewPath = "{$path}"; // storageUrl
        $folderName = "{$path}/pdf";
        set_time_limit(1200);
        $sql = "export HOME=/var/www; /usr/bin/libreoffice --headless --convert-to pdf:writer_pdf_Export {$path}/{$fileName} --outdir {$path}";
        exec($sql, $output, $return_var);
        $fileNameArr = explode('.', $fileName);
        self::PdfToJpg($path, "{$fileNameArr[0]}.pdf", $type);
        $data = [
            //'id'=>$id,
            'path' => "{$path}/{$fileNameArr[0]}.pdf",
            'sql' => $sql,
            'out' => $output,
            'return_var' => $return_var
        ];
        return true;
    }

    public static function PdfToJpg($path, $fileName, $type = "") {
        $dirPath = Yii::getAlias('@storage') . "{$path}";
        $folderName = "{$path}/pdf";
        \backend\modules\sections\classes\JFiles::deleteDir("{$folderName}");
        $createDir = \backend\modules\sections\classes\JFiles::CreateDir("{$folderName}", false);
        if ($createDir) {
            set_time_limit(1200);
            $sql = "convert -density 800 {$path}/{$fileName} {$folderName}/preview.png";

//            $sql = "convert -density 1000 -page a4 {$path}/{$fileName} {$folderName}/preview.jpg";
//$sql="convert -density 1000 -define pdf:fit-page=A4 {$path}/{$fileName} {$folderName}/preview.jpg";
//$sql="convert -density 800 {$path}/{$fileName} {$folderName}/preview.jpg";
            exec($sql, $output, $return_var);
            if ($type != "pdf") {
                @unlink("{$path}/{$fileName}");
            }
            return true;
        }
    }

    public static function imageToText($path) {
        exec("stat {$path}", $des1);
        exec("file {$path}", $des2);
        //return ["type"=>$type];
        $data = \yii\helpers\Json::encode($des1) . \yii\helpers\Json::encode($des2);
        return $data;

//        $images_dir = $folderName;//Yii::getAlias('@storage')."/web/files/1536251432053942100/";
//        $dh  = opendir($images_dir);
//        while (false !== ($filename = readdir($dh))) {
//            $files[] = $filename;
//        }
//        $images=preg_grep ('/\.(jpg|jpeg|png|gif|tif)$/i', $files);
//        $image=[];
//        sort($images);
//        $output = "";
//        
//        foreach($images as $k=>$v){
//            //\appxq\sdii\utils\VarDumper::dump("{$folderName}/{$v}");
//           // $image[$k] = ['src'=>"{$url}/{$v}", 'content'=>'']; 
//            $output .= (new \thiagoalessio\TesseractOCR\TesseractOCR("{$folderName}/{$v}"))->lang('tha','eng')->run();
//        }
//        return $output;
    }
/**
     * 
     * @param type $modelForm array ['filename'=>$filename, 'mark'=>$mark, 'target'=>$target]
     * @param type $template  string "magick convert {filename} -gravity SouthEast {mark} -geometry +20+20  -composite {target}"
     */
    public static function getTemplateMark($modelForm, $template) {

        $path = [];
        foreach ($modelForm as $key => $value) {
            $path["{" . $key . "}"] = $value;
        }
        $master = strtr($template, $path);
        return $master;
    }

    public static function uploadVideo($file, $filePath, $watermark, $status) {
        $format = ["mp4", "mpg", "mpeg", "mov", "avi", "flv", "wmv"];
        $path = "{$filePath}.{$file->extension}";
        if ($file->extension == "mp4") {
            $path = "{$filePath}_mark.{$file->extension}";
            if ($status == '2'){//video clip
                $path = "{$filePath}_marks.{$file->extension}";
            }
            //
        }
        $output = [];
        $mark = Yii::getAlias('@storage') . "/web/{$watermark['path']}/{$watermark['name']}";
        if ($file->saveAs($path)) {//save image
            exec("stat {$path}", $des1);
            exec("file {$path}", $des2);
            $output['detai'] = \yii\helpers\Json::encode($des1) . \yii\helpers\Json::encode($des2);
            $output['file_thumbnail'] = self::getThumbVideo($path, '5', '120x90', "{$filePath}.jpg");

            
            if ($status == '2' && $file->extension == "mp4") {
                
                //$mv = "mv {$path} {$pathTo}";
                //exec($mv, $output, $return_var);
                return [
                    'file_thumbnail'=>$output['file_thumbnail'],
                    'type' => 'mp4',
                    'default' => '1', 
                    'detai' => $output['detai']
                ];
            }
            set_time_limit(1200);
             $modelForm = ['filename' => "{$path}", 'mark' => $mark, 'target' => "{$filePath}_mark.mkv", 'output' => "{$filePath}_marks.mp4"];
            if ($file->extension == "mkv") {
                $tem="ffmpeg -i {$path} -c:v copy  -b:a 128k  {$filePath}.mp4";
                exec($tem, $des1);
                 $modelForm = ['filename' => "{$filePath}.mp4", 'mark' => $mark, 'target' => "{$filePath}_mark.mkv", 'output' => "{$filePath}_marks.mp4"];
            }

           

            $w = $watermark['code'];

            if ($status == '2') {
                $w = \backend\modules\cores\classes\CoreOption::getParams('water_video', 'e');
            }
            
            $template = self::getTemplateMark($modelForm, $w);
            exec($template, $output, $return_var);


             if ($file->extension == "mkv") {
                 @unlink("{$filePath}.mp4");
             }

            @unlink("{$filePath}_mark.mkv");
            // \appxq\sdii\utils\VarDumper::dump($path);
            @unlink("{$path}");
            $output['type'] = 'mp4';
            $output['default'] = 0;

            return $output;
        }
    }
    public static function getThumbVideo($videoFile,$getFromSecond='5', $size="120x90" ,$imageFile){ 
        set_time_limit(1200);
        $cmd = "ffmpeg -i {$videoFile} -an -ss {$getFromSecond} -s {$size} -vframes 1 {$imageFile} -y"; 
        exec($cmd, $output, $return_var);
        $fileName = explode('/', $imageFile);
        
        return end($fileName);
    }

    public static function uploadAudio($file, $filePath) {

        $path = "{$filePath}.{$file->extension}";
        $output = "{$filePath}.mp3";
        $outputs = [];
        if ($file->saveAs($path)) {//save image
            exec("stat {$path}", $des1);
            exec("file {$path}", $des2);
            $outputs['detai'] = \yii\helpers\Json::encode($des1) . \yii\helpers\Json::encode($des2);
            $outputs['type'] = 'mp3';

            set_time_limit(1200);
            $template = "ffmpeg -i {$path} -acodec libmp3lame {$output}";
            exec($template, $output, $return_var);
            return $outputs;
        }
    }

    public static function lengthName($gname, $length = "") {
        $checkthai = preg_replace('/[^ก-๙]/ u', '', $gname);
        ;

        $len = ($length == "") ? 12 : $length;

        //$len = 12;
        if ($checkthai != '') {
            $len = $len * 1;
        }
        if (strlen($gname) > $len) {
            $gname = mb_substr($gname, 0, $len, "utf-8") . '';
        }

        return $gname;
    }

    public static function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            return TRUE;
            throw new \InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                @unlink($file);
            }
        }
        rmdir($dirPath);
    }

    //get image properti
    public static function setImageProperty($path, $jsonData) {
        $data = '';
        $iptc = [
            '2#120' => $jsonData
        ];
        foreach ($iptc as $tag => $string) {
            $tag = substr($tag, 2);
            $data .= self::iptc_make_tag(2, $tag, $string);
        }
        $content = iptcembed($data, $path);
        $fp = fopen($path, "wb");
        fwrite($fp, $content);
        fclose($fp);
    }

    public static function iptc_make_tag($rec, $data, $value) {
        $length = strlen($value);
        $retval = chr(0x1c) . chr($rec) . chr($data);
        if ($length < 0x8000) {
            $retval .= chr($length >> 8) . chr($length & 0xFF);
        } else {
            $retval .= chr(0x80) .
                    chr(0x04) .
                    chr(($length >> 24) & 0xFF) .
                    chr(($length >> 16) & 0xFF) .
                    chr(($length >> 8) & 0xFF) .
                    chr($length & 0xFF);
        }
        return $retval . $value;
    }

    public static function getImageProperty($filePath) {
        $size = getimagesize($filePath, $info);
        $returnArray = null;
        if (isset($info['APP13'])) {
            $iptc = iptcparse($info['APP13']);
            $returnArray = json_decode($iptc["2#120"][0]);
        }
        return $returnArray;
    }

}

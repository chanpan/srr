<?php 

namespace backend\modules\sections\classes;
class CNExcel{
	 public static function Excel2Array($inputFileName,$row_callback=null){
	 	 if (!class_exists('PHPExcel')) return false;
	    try {
	        $inputFileType = \PHPExcel_IOFactory::identify($inputFileName);
	        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
	        $objPHPExcel = $objReader->load($inputFileName);
	    } catch(Exception $e) {
	        return ('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	    }
	    $sheet = $objPHPExcel->getSheet(0); 
	    $highestRow = $sheet->getHighestRow(); 
	    $highestColumn = $sheet->getHighestColumn();
	    $keys = array();
	    $results = array();
	    if(is_callable($row_callback)){
	        for ($row = 1; $row <= $highestRow; $row++){ 
	            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,null,true,false);
	            if ($row === 1){
	                $keys = $rowData[0];
	            } else {
	                $record = array();
	                foreach($rowData[0] as $pos=>$value) $record[$keys[$pos]] = $value; 
	                $row_callback($record);           
	            }
	        } 
	    } else {            
	        for ($row = 1; $row <= $highestRow; $row++){ 
	            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,null,true,false);
	            if ($row === 1){
	                $keys = $rowData[0];
	            } else {
	                $record = array();
	                foreach($rowData[0] as $pos=>$value) $record[$keys[$pos]] = $value; 
	                $results[] = $record;           
	            }
	        } 
	        return $results;
	    }
	 }
	 /*
	 *$filename = \Yii::getAlias('@storage').'/web/demo/sample.txt'
	 */
	 public static function ReadTextFile($filename){
	 	try{
	 		$root_path = \Yii::getAlias('@storage').'/web/files/1543515193001060400/2a9877c0f0d79c34fd3ca7114a38c925.txt';
            //return $filename;
	        $output = '';
            $strFileName = isset($filename) ? $filename : '';//isset($filename) ? $filename : "{$root_path}";
            $objFopen = fopen($strFileName, 'r');
	        if ($objFopen) {
	            while (!feof($objFopen)) {
	                $file = fgets($objFopen, 4096);
	                // echo $file."<br>";
	                $output .= $file;
	            }
	            fclose($objFopen);
	        }
            return $output;
	 	}catch(\Exception $e){
	 		return $e;
	 	}
	 }
}

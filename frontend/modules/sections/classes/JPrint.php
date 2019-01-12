<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\sections\classes;
use kartik\mpdf\Pdf;
/**
 * Description of JPrint
 *
 * @author chanpan
 */
class JPrint {
    public static function printPDF($layout, $paperSize, $title, $content, $fileName) {
         
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_FILE,
            'filename' => $fileName,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@frontend/web/css/pdf.css', 
            // any css to be embedded if required
            //'cssInline' => '.bd{border:1.5px solid; text-align: center;} .ar{text-align:right} .imgbd{border:1px solid}',
            // set mPDF properties on the fly
            'options' => ['title' => $title],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => false, //['Krajee Report Header'],
                'SetFooter' => false, //['{PAGENO}'],
            ]
        ]);
 
        return $pdf->render();
    }

}

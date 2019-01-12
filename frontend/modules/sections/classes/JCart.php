<?php

namespace frontend\modules\sections\classes;

use Yii;
use yii\web\Session;

class JCart {

    public static function addCart($id, $arrData, $amount, $action) {
        $session = Yii::$app->session;   
        $id = isset($arrData['id']) ? $arrData['id'] : '';
        $name = isset($arrData['name']) ? $arrData['name'] : '';
        $detail = isset($arrData['detail']) ? $arrData['detail'] : '';
        $price = isset($arrData['price']) ? $arrData['price'] : 0;
        $image = isset($arrData['image']) ? $arrData['image'] : '';
        $size = isset($arrData['size']) ? $arrData['size'] : '';
        
        
        if (!isset($session["cart"])) {
            $cart[$id] = [
                'id'            =>$id,
                'pro_name'      => $name,
                'pro_detail'    => $detail,
                'pro_price'     => $price,
                'image'         => $image,                
                'amount'        => (int) $amount,
                'sum'           => (int)$amount * $price,
                'size'          =>    $size
            ];
            
        } else {
           
            $cart = $session["cart"];
            if (array_key_exists($id, $cart)) {
                switch ($action) {
                    case "add":
                        $cart[$id] = [
                            'id'            =>$id,
                            'pro_name'      => $name,
                            'pro_detail'    => $detail,
                            'pro_price'     => $price,
                            'image'         => $image, 
                            'amount'        => (int) $cart[$id]["amount"] + 1,
                            'sum'           => ((int) $cart[$id]["amount"] + 1) * $price,
                            'size'          =>    $size
                        ];
                        
                        break;
                    case "del":
                        $cart[$id] = [
                            'id'            =>$id,
                            'pro_name'      => $name,
                            'pro_detail'    => $detail,
                            'pro_price'     => $price,
                            'image'         => $image, 
                            'amount'        => (int) $cart[$id]["amount"] - 1,
                            'sum'           => ((int) $cart[$id]["amount"] - 1) * $price,
                            'size'          =>    $size
                        ];
                        break;
                }
            } else {
               // \appxq\sdii\utils\VarDumper::dump($price);
                $cart[$id] = [
                    'id'            =>$id,
                    'pro_name'      => $name,
                    'pro_detail'    => $detail,
                    'pro_price'     => $price,
                    'image'         => $image, 
                    'amount'        => (int) $amount,
                    'sum'           => $amount * $price,
                    'size'          =>    $size
                ];
            }
        }
        $session["cart"] = $cart;
        // $session->destroy();
    }

    public static function sumCart() {
        $sum = 0;
        foreach (Yii::$app->session["cart"] as $key => $value) {
            $sum += $value["pro_price"];
        }
        return $sum;
    }

}

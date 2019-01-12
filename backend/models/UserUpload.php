<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\User;

/**
 * Create user form.
 */
class UserUpload extends Model
{
    public $filename;
    public function rules()
    {
        return [
            [['filename'], 'file', 'extensions' => 'csv,xls,xlsx', 'skipOnEmpty' => true]
        ];
    }

}

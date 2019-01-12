<?php
 
namespace backend\modules\cores;

use Yii; 
class JYii2DbRbac extends \yii\base\Module{
    public $controllerNamespace = 'backend\modules\cores\controllers';
    public $theme = false;
    public $userClass;
    public $accessRoles;

    public function init()
    {
        parent::init();
        $this->registerTranslations();

        if ($this->theme) {
            Yii::$app->view->theme = new \yii\base\Theme($this->theme);
        }
    }

    public function registerTranslations()
    {
        
        if (!isset(Yii::$app->i18n->translations['appmenu'])) {
            Yii::$app->i18n->translations['appmenu'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@developeruz/db_rbac/messages',
            ];
            //\appxq\sdii\utils\VarDumper::dump(Yii::$app->i18n->translations['db_rbac']);
        }
    }

    public static function t($category, $message, $params = [], $language = null)
    {        
        return Yii::t('appmenu' . $category, $message, $params, $language);
    }
}

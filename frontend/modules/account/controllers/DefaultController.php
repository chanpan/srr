<?php

namespace frontend\modules\account\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\User;
use common\models\UserProfile;
use frontend\modules\account\models\MessageForm;
use frontend\modules\account\models\PasswordForm;
use frontend\modules\account\models\search\UserSearch;

/**
 * Default controller.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
public function beforeAction($action)
    {
      $this->layout = "@frontend/themes/siriraj2/layouts/main-second"; 
      return parent::beforeAction($action);
    }
    /**
     * Settings User models.
     *
     * @return mixed
     */
    public function actionSettings()
    {
        
        
        $model = Yii::$app->user->identity->userProfile;
        $user = User::findOne($model->user_id);
        $breadcrumbs=[];
        $breadcrumbs_arr = [
            [
                'label' =>\Yii::t('cart', 'Home'), 
                'url' =>'/sections/session-management',
                'icon'=>'fa-home'
            ],
            [
                'label' => \Yii::t('user', 'Settings')
            ]
        ];
        foreach($breadcrumbs_arr as $key=>$v){
            $breadcrumbs[$key]=$v;
        } 
        if ($model->load(Yii::$app->request->post())) {
            //$model->sap_id = isset($_POST['UserProfile']['sap_id']) ? $_POST['UserProfile']['sap_id'] : '';
            $model->sitecode = isset($_POST['UserProfile']['sitecode']) ? $_POST['UserProfile']['sitecode'] : '';
            $model->sitecode = isset($_POST['UserProfile']['position']) ? $_POST['UserProfile']['position'] : '';
            //\appxq\sdii\utils\VarDumper::dump($_POST);
            if($model->save()){
                return \janpan\jn\classes\JResponse::getSuccess("Success");
            }else{
                return \janpan\jn\classes\JResponse::getError(\yii\helpers\Json::encode($model->errors));
            }
            
        } else {
            return $this->render('settings', ['model' => $model,'breadcrumb'=>$breadcrumbs,'user'=>$user]);
        }
    }

    /**
     * @inheritdoc
     */
    public function actionPassword()
    {
        $model = new PasswordForm();
        $model->setUser(Yii::$app->user->identity);
        $breadcrumbs=[];
        $breadcrumbs_arr = [
            [
                'label' =>\Yii::t('cart', 'Home'), 
                'url' =>'/sections/session-management',
                'icon'=>'fa-home'
            ],
            [
                'label' => \Yii::t('user', 'Change password')
            ]
        ];
        foreach($breadcrumbs_arr as $key=>$v){
            $breadcrumbs[$key]=$v;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('frontend', 'Your password has been successfully changed.'));

            return $this->refresh();
        } else {
            return $this->render('password', ['model' => $model, 'breadcrumb'=>$breadcrumbs]);
        }
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionUsers()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC],
        ];

        return $this->render('users', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     *
     * @param int $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->redirect(['/site/index']);
    }

    /**
     * Displays message page.
     *
     * @return mixed
     */
    public function actionMessage($id)
    {
        $user = User::findOne($id);
        if ($user) {
            $model = new MessageForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->sendEmail($user->email)) {
                    Yii::$app->session->setFlash('success', Yii::t('frontend', 'Your message has been sent successfully.'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('frontend', 'There was an error sending your message.'));
                }

                return $this->refresh();
            } else {
                return $this->render('message', [
                    'model' => $model,
                    'user' => $user,
                ]);
            }
        } else {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
        }
    }
}
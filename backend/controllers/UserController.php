<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\search\UserSearch;
use backend\models\UserForm;
use common\models\User;
use common\models\UserProfile;

/**
 * Class UserController.
 */
class UserController extends Controller
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

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $search = Yii::$app->request->get('search', '');
        $role = Yii::$app->request->get('UserSearch', '');
        
        
        
        $user = User::find()->innerJoinWith('userProfile', true);
        $user->orFilterWhere(['like', 'username', $search])
                ->orFilterWhere(['like', 'email', $search])
                ->orFilterWhere(['like','firstname',  $search])
                ->orFilterWhere(['like','lastname',  $search])
                ->orFilterWhere(['like','sap_id',  $search])
                ->orFilterWhere(['like','sitecode',  $search]);
        
        if($role != ''){
            $created_at = $role['created_at'];
            $role = $role['role'];
            
            //$created_at = $role['created_at'];
            
            $roles = (new \yii\db\Query())->select('*')->from('auth_assignment')->where(['item_name'=>$role])->all();
            $user_id=[];
            //\appxq\sdii\utils\VarDumper::dump($roles);
            $user = User::find();
            //$user_id = '';
            if(!empty($roles)){
                foreach($roles as $k=>$v){
                    array_push($user_id, $v['user_id']);
                }
                $user_id = join(',', $user_id);
                
                $user = $user->where("id in({$user_id})")
                        ->innerJoinWith('userProfile', true);
            }
            if(!empty($created_at)){
               
                $begin = strtotime("{$created_at} 00:00:01");
                $end = strtotime("{$created_at} 23:59:59");
                //echo "between $begin AND $end";
                $user = $user->where("created_at between {$begin} AND {$end} ")
                ->innerJoinWith('userProfile', true);
               // \appxq\sdii\utils\VarDumper::dump($created_at);
            }
            //\appxq\sdii\utils\VarDumper::dump($user->all());
        }
        
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $user,
            'pagination' => ['pagesize' => 100],
        ]);
        //\appxq\sdii\utils\VarDumper::dump($_GET);
//        $dataProvider->sort = [
//            'defaultOrder' => ['created_at' => SORT_DESC],
//        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserForm();
        $model->setScenario('create');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = new UserForm();
        $user->setModel($this->findModel($id));
        $profile = UserProfile::findOne($id);

        if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
           
            $isValid = $user->validate();
            $isValid = $profile->validate() && $isValid;
            
            if ($isValid) {
                $user->save(false);
                $profile->save(false);
                Yii::$app->session->setFlash('success', Yii::t('backend', 'แก้ไขผู้ใช้สำเร็จ'));
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'user' => $user,
            'profile' => $profile,
            'roles' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'),
        ]);
    }
    
    public function actionProfile()
    {
        $id = isset(Yii::$app->user->id) ? Yii::$app->user->id : '';        
        $user = new UserForm();
        $user->setModel($this->findModel($id));
        $profile = UserProfile::findOne($id);

        if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
           
            $isValid = $user->validate();
            $isValid = $profile->validate() && $isValid;
            
            if ($isValid) {
                $user->save(false);
                $profile->image = $_POST['UserProfile']['image'];
                if($profile->save(FALSE)){
                   // \appxq\sdii\utils\VarDumper::dump($_POST); 
                }
                 
                 return $this->refresh();
            }
        }

        return $this->render('profile', [
            'user' => $user,
            'profile' => $profile,
            'roles' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', Yii::t('backend', 'You can not remove your own account.'));
        } else {
            // remove avatar
//            $avatar = UserProfile::findOne($id)->avatar_path;
//            if ($avatar) {
//                unlink(Yii::getAlias('@storage/avatars/' . $avatar));
//            }
            Yii::$app->authManager->revokeAll($id);
            $this->findModel($id)->delete();

            Yii::$app->session->setFlash('success', Yii::t('backend', 'User has been deleted.'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionManager($id, $auth) { 
      
        //administrator , users , manager
        $getAuth = \Yii::$app->authManager->getAssignment($auth, $id);
        $roles_db = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        
         
        if ($id == \Yii::$app->user->identity->getId()) {            
            
            return \janpan\jn\classes\JResponse::getError("ไม่สามารถอนุมัติตัวเองได้");
        } else {
            $authorRole = Yii::$app->authManager->getRole($auth);
            //\appxq\sdii\utils\VarDumper::dump($authorRole);
            //Yii::$app->authManager->revoke($authorRole, $id);
            $model = UserProfile::findOne($id);
            if($model->approval == 1){
                $setAuth = Yii::$app->authManager->revoke($authorRole, $id);
                $model->approval = 0;
                $model->save();
            }else{
                $userId = Yii::$app->user->id;
                $setAuth = Yii::$app->authManager->revoke($authorRole, $id);
                $setAuth = Yii::$app->authManager->assign($authorRole, $id);
                $model->approval = 1;
                $model->approval_by = $userId;
                $model->save();
            }
            
            return \janpan\jn\classes\JResponse::getSuccess("Success");
        }
    }
    public function actionSaveUser(){
        
        try{
            $username = \Yii::$app->request->post('username', '');
            $password = \Yii::$app->request->post('password', '');
            $email = \Yii::$app->request->post('email', '');
            $status = \Yii::$app->request->post('status', '');
            $position = \Yii::$app->request->post('position', '');
            $firstname = \Yii::$app->request->post('firstname', '');
            $lastname = \Yii::$app->request->post('lastname', '');
            $sitecode = \Yii::$app->request->post('sitecode', '');
            $sap_id = \Yii::$app->request->post('sap_id', '');
            $sex = \Yii::$app->request->post('sex', '');

            $model = new UserForm();
            $model->setScenario('create');
            $model->username = $username;
            $model->password = $password;
            $model->email = $email;
            $model->status = 1;
            $model->position = $position;
            $model->firstname = $firstname;
            $model->lastname = $lastname;
            $model->sitecode = $sitecode;//isset($sitecode) ? $sitecode : '';
            $model->sap_id = $sap_id;// isset($sapid) ? $sapid : '';
            $model->sex = $sex; //isset($sex) ? $sex : '';
            if($model->save()){
                return \janpan\jn\classes\JResponse::getSuccess('Success');
            }else{
                return \janpan\jn\classes\JResponse::getError('Error');
            }
        } catch (\yii\db\Exception $ex) {
            return \janpan\jn\classes\JResponse::getError('Error', $ex);
        }
    }
    public function actionImportExcel()
    {
        $model=new \backend\models\UserUpload();
        if($model->load(Yii::$app->request->post()) ){
            
            $files = \yii\web\UploadedFile::getInstance($model, 'filename');
            $newFile = \appxq\sdii\utils\SDUtility::getMillisecTime();
            $fileLocation    = Yii::getAlias('@storage') . "/web/images/{$newFile}.{$files->extension}";
            if($files->saveAs($fileLocation)){
               // \appxq\sdii\utils\VarDumper::dump($fileLocation);
            
                try{
                    ini_set('memory_limit', '-1');
                    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
                    set_time_limit(0);
                   // $fileLocation = '/Users/chanpan/www/srr/storage/web/images/1541690821013037200.xls';
                    $inputFileType = \PHPExcel_IOFactory::identify($fileLocation);  
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);  
                    $objReader->setReadDataOnly(true);  
                    $objPHPExcel = $objReader->load($fileLocation);  
                    
                    // for No header
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                    $highestRow = $objWorksheet->getHighestRow();
                    $highestColumn = $objWorksheet->getHighestColumn();
                    
                    
                    $r = -1;
                    $namedDataArray = array();
                    for ($row = 2; $row <= $highestRow; ++$row) {
                        $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
                        if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                            ++$r;
                            $namedDataArray[$r] = $dataRow[$row];
                        }
                    }
                    $out = [];
                   //\appxq\sdii\utils\VarDumper::dump($namedDataArray);
                    foreach($namedDataArray as $k=>$v){
                        $username = "{$v['A']}";
                        $password = "{$v['A']}";
                        $sapid    = "{$v['A']}";
                        $name     = "{$v['B']}";
                        $position = "{$v['C']}";
                        $sitecode = "{$v['D']},{$v['E']},{$v['F']}";
                        $approval = ($v['G'] == 'Active') ? 1 : 0;
                        $nameArr  = explode(' ', $name);
                        
//                        $model = new UserForm();
//                        $model->setScenario('create');
//                        $model->username    = isset($username) ? $username : '123456';
//                        $model->password    = isset($password) ? $password : '123456';
//                        $model->email       = "{$username}@gmail.com";
//                        $model->status      = 1;
//                        $model->position    = $position;
//                        $model->firstname   = isset($nameArr[1]) ? $nameArr[1] : '';
//                        $model->lastname    = isset($nameArr[2]) ? $nameArr[2] : '';
//                        $model->sitecode    = isset($sitecode) ? $sitecode : '';
//                        $model->sap_id      = isset($sapid) ? $sapid : '';
//                        $model->sex         = isset($nameArr[0]) ? $nameArr[0] : '';
                        $out[$k] = [
                            'username'=>isset($username) ? $username : '123456',
                            'password'=>isset($username) ? $username : '123456',
                            'email'=> "{$username}@gmail.com",
                            'status'=>1,
                            'firstname'=>isset($nameArr[1]) ? $nameArr[1] : '', 
                            'lastname'=> isset($nameArr[2]) ? $nameArr[2] : '',
                            'position'=> isset($position) ? $position : '',
                            'sitecode'=> isset($sitecode) ? $sitecode : '',  
                            'sap_id'=>   isset($sapid) ? $sapid : '',
                            'sex'=>      isset($nameArr[0]) ? $nameArr[0] : ''  
                        ];
//                        if(!$model->save()){
//                            return \janpan\jn\classes\JResponse::getError("error ", $model->errors);
//                        }
                    }
                   
                    exec("rm -rf {$fileLocation}");
                    return \janpan\jn\classes\JResponse::getSuccess("success", $out);
                    
                    
                } catch (\yii\base\Exception $ex) {
                    return \janpan\jn\classes\JResponse::getError('อ่านข้อมูลไม่สำเร็จ รูปแบบไฟล์ไม่ถูกต้อง');
                }
                
                 
            }//end if
            //\appxq\sdii\utils\VarDumper::dump($files->extension);
            
        }
        return $this->renderAjax('import-excel', ['model'=>$model]); 
    }

}

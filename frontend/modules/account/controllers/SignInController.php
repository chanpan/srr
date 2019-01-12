<?php

namespace frontend\modules\account\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\LoginForm;
use common\models\User;
use frontend\modules\account\models\PasswordResetRequestForm;
use frontend\modules\account\models\ResetPasswordForm;
use frontend\modules\account\models\SignupForm;

/**
 * Class UserController.
 */
class SignInController extends Controller
{
    public function beforeAction($action)
    {
      $this->layout = "@frontend/themes/siriraj2/layouts/main-second"; 
      return parent::beforeAction($action);
    }
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
                        'actions' => ['login', 'signup', 'confirm-email', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['login', 'signup', 'confirm-email', 'request-password-reset', 'reset-password'],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['default/view', 'id' => Yii::$app->user->id]);
                        },
                    ],
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

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $model = Yii::$app->user->identity;
            $model->ip = Yii::$app->request->userIP;
            $model->save();            
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', ['model' => $model]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['/account/sign-in/login']);
        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {   
        if (Yii::$app->keyStorage->get('frontend.registration')) {
            $model = new SignupForm();
            if ($model->load(Yii::$app->request->post())) {
                //\appxq\sdii\utils\VarDumper::dump(Yii::$app->keyStorage->get('frontend.email-confirm'));
                if ($user = $model->signup()) {
//                    if (Yii::$app->getUser()->login($user)) {
//                            return $this->goHome();
//                    }
                    if (Yii::$app->keyStorage->get('frontend.email-confirm')) {
                       
                        if ($model->sendEmail()) {
                            return \janpan\jn\classes\JResponse::getSuccess('สร้างบัญชีของคุณเรียบร้อยแล้ว ตรวจสอบอีเมลของคุณเพื่อดูคำแนะนำเพิ่มเติม');
                            //Yii::$app->session->setFlash('success', Yii::t('frontend', 'สร้างบัญชีของคุณเรียบร้อยแล้ว ตรวจสอบอีเมลของคุณเพื่อดูคำแนะนำเพิ่มเติม'));
                        } else {
                            return \janpan\jn\classes\JResponse::getError('มีข้อผิดพลาดในการส่งข้อความ');
                            //Yii::$app->session->setFlash('error', Yii::t('frontend', 'มีข้อผิดพลาดในการส่งข้อความของคุณเป็น.'));
                        }
                        //return $this->refresh();
                    } else {
                        // автологин
                        if (Yii::$app->getUser()->login($user)) {
                            return $this->goHome();
                        }
                    }
                }
            }

            return $this->render('signup', ['model' => $model]);
        } else {
            return $this->goHome();
        }
    }

    /**
     * @inheritdoc
     */
    public function actionConfirmEmail($id, $token)
    {
        $user = User::find()->where([
            'id' => $id,
            'access_token' => $token,
            'status'=> User::STATUS_INACTIVE,
        ])->one();

        if ($user) {
            $user->status = User::STATUS_ACTIVE;
            $user->removeAccessToken();
            $user->save();
            \Yii::$app->user->login($user);
            Yii::$app->session->setFlash('success', Yii::t('frontend', 'Your account has been successfully activated.'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'Error activate your account.'));
        }

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        $message = '';
        $status = '';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->sendEmail()) {
                return \janpan\jn\classes\JResponse::getSuccess('ตรวจสอบอีเมลของคุณเพื่อดูคำแนะนำเพิ่มเติม');
            } else {
                return \janpan\jn\classes\JResponse::getError('ขออภัยเราไม่สามารถรีเซ็ตรหัสผ่านสำหรับที่อยู่อีเมลที่ให้มาได้');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
            'message'=>$message,
            'status'=>$status
                
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            //Yii::$app->session->setFlash('success', Yii::t('frontend', 'New password saved.'));
            return \janpan\jn\classes\JResponse::getSuccess("รีเซ็ตรหัสผ่านสำเร็จ");

            //return $this->goHome();
        }

        return $this->render('resetPassword', ['model' => $model]);
    }
}

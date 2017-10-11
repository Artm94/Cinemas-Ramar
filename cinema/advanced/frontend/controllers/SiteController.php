<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\PerfilUsuario;
use frontend\models\ContactForm;
use frontend\models\ChangePasswordForm;
use frontend\models\DeleteAccountForm;
use common\models\Peliculas;
use common\models\PeliculasSearch;
use common\models\User;
use common\models\Boletos;
use frontend\models\BoletosSearch;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        date_default_timezone_set('America/Mexico_City');
        $inicioSemana = date('Y-m-d H:i:s', strtotime("next hour"));
        $finSemana = date('Y-m-d H:i:s', strtotime("Sunday this week"));
        $peliculas = Peliculas::find()->distinct(true)->where("id IN (SELECT pelicula_id FROM proyeccion WHERE fecha_funcion>='$inicioSemana' AND fecha_funcion<='$finSemana')")->limit(4)->all();
        $this->layout = 'main.php';
        return $this->render('index', [
            'peliculas' => $peliculas,
            ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'loginLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $userId = Yii::$app->user->identity->getId();
        $user = User::findOne($userId);
        $profile = PerfilUsuario::findOne($userId);
        $searchModel = new BoletosSearch();
        $boletos = $searchModel->search(Yii::$app->request->queryParams);
        $passwordModel = new ChangePasswordForm();
        $passwordModel->username = Yii::$app->user->identity->username;
        $deleteModel = new DeleteAccountForm();
        $deleteModel->username = Yii::$app->user->identity->username;
        return $this->render('profile', [
            'user' => $user,
            'profile' => $profile,
            'boletos' => $boletos,
            'passwordModel' => $passwordModel,
            'deleteModel' => $deleteModel,
            ]);
    }

    public function actionUpdateProfileInfo(){
        $model = User::findByUsername(Yii::$app->user->identity->username);
        $profile = PerfilUsuario::findOne(Yii::$app->user->identity->getId());
        if($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())){
            if($model->validate() && $profile->validate()){
                $profile->file = UploadedFile::getInstance($profile, 'file');
                if(!empty($profile->file)){
                    $profile->file->saveAs('img/profile/' . $model->username . '.' . $profile->file->extension);
                    $profile->foto_perfil = Url::to('@web') . '/img/profile/' . $model->username . '.' . $profile->file->extension;
            }
            if($model->save() && $profile->save(false)){
                return 1;
            }
            }
        }
        return 0;
    }

    public function actionDeleteAccount()
    {
        $model = new DeleteAccountForm();
        $model->username = Yii::$app->user->identity->username;
        if($model->load(Yii::$app->request->post())){
            if($user = $model->identifyUser()){
                Yii::$app->user->logout();
                $boletos = Boletos::find()->where(['usuario_id' => $user->id])->all();
                foreach ($boletos as $boleto) {
                    $boleto->id = 0;
                    $boleto->save();
                }
                PerfilUsuario::findOne($user->id)->delete();
                $user->delete();
                return $this->goHome();
            }
        }else{
            return $model->getFirstError('password');
        }
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        $model->username = Yii::$app->user->identity->username;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->changePassword()){
                return 1;
            }
        }
        return 0;
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'signupLayout';
        $model = new SignupForm();
        $profile = new PerfilUsuario();
        if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            if($model->validate() && $profile->validate()){
                if ($user = $model->signup()) {
                    $profile->id = $user->id;
                    //Aqui permisos de usuario
                    $profile->tipo = 'cliente';
                    //Aqui guardar despues de configurar el profile
                    $profile->save();
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();
                    }
                }
            }
        }
        return $this->render('signup', [
            'model' => $model,
            'profile' => $profile
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
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
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}

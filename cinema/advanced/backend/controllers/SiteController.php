<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\ChangePasswordForm;
use common\models\User;
use common\models\PerfilUsuario;
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
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'change-password', 'update-profile'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['peliculas/index']);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
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

    public function actionChangePassword()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $passwordModel = new ChangePasswordForm();
        $passwordModel->username = Yii::$app->user->identity->username;
        if($passwordModel->load(Yii::$app->request->post()) && $passwordModel->validate()){
            if($passwordModel->changePassword()){
                $this->redirect(['site/index']);
            }
        }
        return $this->render('credentials', [
                'passwordModel' => $passwordModel,
            ]);
    }

    public function actionUpdateProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $userId = Yii::$app->user->identity->getId();
        $user = User::findOne($userId);
        $profile = PerfilUsuario::findOne($userId);

        if($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())){
            if($user->validate() && $profile->validate()){
                $profile->file = UploadedFile::getInstance($profile, 'file');
                if(!empty($profile->file)){
                    $profile->file->saveAs('img/profile/' . $user->username . '.' . $profile->file->extension);
                    $profile->foto_perfil = Url::to('@web') . '/img/profile/' . $user->username . '.' . $profile->file->extension;
            }
            if($user->save() && $profile->save(false)){
                $this->redirect(['site/index']);
            }
            }
        }

        return $this->render('profile', [
            'user' => $user,
            'profile' => $profile
            ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

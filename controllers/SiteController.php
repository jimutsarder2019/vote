<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Users;
use app\components\ApplicationHelper;
use app\init\CustomController;


class SiteController extends CustomController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
			'as beforeRequest' => [  //if guest user access site so, redirect to login page.
				'class' => 'yii\filters\AccessControl',
				'rules' => [
					[
						'actions' => ['index', 'login', 'error'],
						'allow' => true,
					],
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
     * {@inheritdoc}
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
     * @return string
     */
    public function actionIndex()
    {
		$this->layout = 'empty';
		
		$sql = "SELECT image_url FROM tbl_homepage_popup where status = 1 order by id desc";
		$popup = Yii::$app->db->createCommand($sql)->queryScalar();
		
		$sql = "SELECT company FROM voter where license='thana'";
		$company_thana = Yii::$app->db->createCommand($sql)->queryColumn();
		
		$sql = "SELECT company FROM voter where license='district'";
		$company_district = Yii::$app->db->createCommand($sql)->queryColumn();
		return $this->render('index', ['popup'=>$popup, 'company_thana'=>$company_thana, 'company_district'=>$company_district]);
        //return $this->redirect(['login']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
		$this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['dashboard/index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
			$users = Users::find()->where(['id' => Yii::$app->user->id])->one();
			if(isset($users->role) && $users->role){
			    Yii::$app->session->set('user_role', $users->role);
			}
			ApplicationHelper::loginHistoryStore();
			return $this->redirect(['dashboard/index']);

        }
		
		$login_logo = Yii::$app->db->createCommand( 'SELECT login_logo FROM settings where id=1' )->queryScalar();

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
			'login_logo' => $login_logo
        ]);
    }
	
	public function actionSystem()
    {
		$this->layout = 'frontend';

		$license_data = CustomController::getLicenseData();
		
        return $this->render('system', ['license_data'=>$license_data]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}

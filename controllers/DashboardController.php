<?php

namespace app\controllers;

ini_set('max_execution_time', '300');

require_once __DIR__ . '/../api/vendor/autoload.php';

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Router;
use app\init\CustomController;
use \RouterOS\Config;
use \RouterOS\Client;
use \RouterOS\Query;

class DashboardController extends CustomController
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
						'actions' => ['login', 'error'],
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
		$this->layout = 'frontend';
		$routers = Yii::$app->db->createCommand( 'SELECT * FROM voter ORDER BY id desc' )->queryAll();
		$users = Yii::$app->db->createCommand( 'SELECT * FROM user WHERE role > 1 ORDER BY id desc' )->queryAll();
		$visit_done = Yii::$app->db->createCommand( 'SELECT COUNT(*) FROM voter WHERE visit_done = 1' )->queryScalar();
		$call_done = Yii::$app->db->createCommand( 'SELECT COUNT(*) FROM voter WHERE call_done = 1' )->queryScalar();
		
		
        return $this->render('index', ['router_data'=>$routers, 
		'user_data'=>$users,
		'users_count'=>0, 
		'router_count'=>count($routers),
		]);
    }
}

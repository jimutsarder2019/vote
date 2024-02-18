<?php

namespace app\controllers;

use Yii;
use app\models\Voter;
use app\models\VoterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * VoterController implements the CRUD actions for Voter model.
 */
class VoterController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        //'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Voter models.
     *
     * @return string
     */
    public function actionIndex()
    {
		$page = 'voter';
		$type = Yii::$app->getRequest()->getQueryParam('type');
		$this->layout = 'frontend';
        $searchModel = new VoterSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        if($type){
			$page = $type;
		}
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
			''
        ]);
    }

    /**
     * Displays a single Voter model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$this->layout = 'frontend';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Voter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
		$this->layout = 'frontend';
        $model = new Voter();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Voter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$this->layout = 'frontend';
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	public function actionVisitDone()
    {
		$id = Yii::$app->getRequest()->getQueryParam('vid');
		$model = $this->findModel($id);
        if (!empty($model)) {
			$model->visit_done = 1;
			$model->visit_done_date = date('Y-m-d');
			if ($model->save(false)) {
				return $this->redirect(['index']);
			}
        } else {
            Yii::$app->session->setFlash('error', 'Voter Not found');
            return $this->redirect(['index']);
        }
    }
	
	public function actionCallDone()
    {
		$id = Yii::$app->getRequest()->getQueryParam('vid');
		$model = $this->findModel($id);
        if (!empty($model)) {
			$model->call_done = 1;
			$model->call_done_date = date('Y-m-d');
			if ($model->save(false)) {
				return $this->redirect(['index']);
			}
        } else {
            Yii::$app->session->setFlash('error', 'Voter Not found');
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes an existing Voter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Voter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Voter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Voter::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace app\controllers;

use Yii;
use app\models\Voter;
use app\models\VoterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\SmsHelper;
use yii\web\UploadedFile;

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
	
	
	public function actionSearch()
    {
		$this->layout = 'frontend';
        return $this->render('search');
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
		$message = 'ISPAB-2024: Visit done';
        if (!empty($model)) {
			$model->visit_done = 1;
			$model->visit_done_date = date('Y-m-d');
			if ($model->save(false)) {
				if($model->mobile1){
					if(SmsHelper::sendMessage($message, $model->mobile1)){
						return $this->redirect(['index']);
					}
				}
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
		$message = 'ISPAB-2024: Call done';
        if (!empty($model)) {
			$model->call_done = 1;
			$model->call_done_date = date('Y-m-d');
			if ($model->save(false)) {
				if($model->mobile1){
					if(SmsHelper::sendMessage($message, $model->mobile1)){
						return $this->redirect(['index']);
					}
				}
			}
        } else {
            Yii::$app->session->setFlash('error', 'Voter Not found');
            return $this->redirect(['index']);
        }
    }
	
	public function actionGet()
    {
		$sql = 'SELECT * FROM voter';
		$voters = Yii::$app->db->createCommand($sql)->queryAll();
        die(json_encode(['voters'=>$voters]));
    }
	
	
	public function actionUploadCsv()
    {
		$this->layout = 'frontend';
        if(1 || Yii::$app->user->can('employee_attendance_upload_csv')){
            $model = new Voter();
            if ($model->load(Yii::$app->request->post())) {
                $csv_file_data = UploadedFile::getInstance($model, 'csv_file');
                try {
                    $transaction = Yii::$app->db->beginTransaction();
                    $handle = fopen("$csv_file_data->tempName", "r");
                    $row = 1;
                    $insert_data_count = 0;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if ($row > 1) {
							print '<pre>';
							print_r($data);
							print '</pre>';
							die;
                            $voter = new Voter();
                            $voter->company = $data[0];
                            $voter->name = $data[0];
                            $voter->ispab_member = $data[0];
                            $voter->voter_no = $data[0];
                            $voter->mobile1 = $data[0];
                            $voter->email = $data[0];
                            $voter->thana = $data[0];
                            $voter->district = $data[0];
                            $voter->address = $data[0];
                            if ($voter->save(false)) {
                                $insert_data_count++;
                            }
                        }
                        $row++;
                    }
                    $transaction->commit();
                } catch (Exception $error) {
                    $transaction->rollback();
                }
                if ($insert_data_count > 0) {
                    Yii::$app->session->setFlash('success', 'Successfully saved');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'Error in saving');
                    return $this->redirect(['index']);
                }
            }
            return $this->render('upload_csv', [
                'model' => $model,
            ]);
        }else{
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
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

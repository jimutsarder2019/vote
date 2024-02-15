<?php

namespace app\controllers;

use Yii;
use app\models\Visitor;
use app\models\VisitorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * VisitorController implements the CRUD actions for Visitor model.
 */
class VisitorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Visitor models.
     * @return mixed
     */
    public function actionIndex222222()
    {
        $searchModel = new VisitorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionIndex()
    {
        $this->layout = 'frontend';
        $current_date = new \DateTime();
        $start_date = $current_date->format('Y-m-d');
        $m_start_date = $start_date;
        $m_end_date = $start_date;
        $today = Visitor::find()->where(['between', 'date', $m_start_date, $m_end_date])->all();
        $today_count = count($today);
        
        $start_date = date('Y-m-01'); // hard-coded '01' for first day
        $end_date  = date('Y-m-t');
        $m_start_date = $start_date;
        $m_end_date = $end_date;
        $month = Visitor::find()->where(['between', 'date', $m_start_date, $m_end_date])->all();
        $month_count = count($month);
        
        $all = Visitor::find()->all();
        $all_count = count($all);
        $search_parameter = '';
                
        $type = Yii::$app->request->get('type');

        if (Yii::$app->request->post()) {
            $start_date = Yii::$app->request->post('start_date');
            $end_date = Yii::$app->request->post('end_date');
            $SearchOrder = Yii::$app->request->get('VisitorSearch');
            $search_parameter = '';
            if (!empty($start_date) && !empty($end_date)) {
                
                $m_start_date = $start_date;
                $m_end_date = $end_date;

                //$m_end_date = date('Y-m-d', strtotime($end_date . ' +1 day'));
                
                $query = Visitor::find()->where(['between', 'date', $m_start_date, $m_end_date]);
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                ]);
                $searchModel = new VisitorSearch();
                return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'search_parameter'=>$search_parameter,
                    'today_count'=>$today_count,
                    'month_count'=>$month_count,
                    'all_count'=>$all_count
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'Please Provide Start Date & End Date');
                return $this->redirect(['index']);
            }
        }elseif($type){
            if($type === 'today'){
                $current_date = new \DateTime();
                $start_date = $current_date->format('Y-m-d');
                $m_start_date = $start_date;
                $m_end_date = $start_date;
                $query = Visitor::find()->where(['between', 'date', $m_start_date, $m_end_date]);
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                ]);
                $searchModel = new VisitorSearch();
                return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'search_parameter'=>$search_parameter,
                                        'today_count'=>$today_count,
                    'month_count'=>$month_count,
                    'all_count'=>$all_count
                ]);
            }else{
                $start_date = date('Y-m-01'); // hard-coded '01' for first day
                $end_date  = date('Y-m-t');
                $m_start_date = $start_date;
                $m_end_date = $end_date;
                $query = Visitor::find()->where(['between', 'date', $m_start_date, $m_end_date]);
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                ]);
                $searchModel = new VisitorSearch();
                return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'search_parameter'=>$search_parameter,
                                        'today_count'=>$today_count,
                    'month_count'=>$month_count,
                    'all_count'=>$all_count
                ]);
            }
        }
        $searchModel = new VisitorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $SEARCH_PARAMS = Yii::$app->request->queryParams;
        $search_parameter = '';
        if(isset($SEARCH_PARAMS['VisitorSearch']) && !empty($SEARCH_PARAMS['VisitorSearch'])){
            foreach($SEARCH_PARAMS['VisitorSearch'] as $key=>$search_order){
                if($search_order){
                    $search_parameter .= '&'.$key.'='.$search_order;
                }
            }
        }
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'search_parameter'=>$search_parameter,
                                'today_count'=>$today_count,
                    'month_count'=>$month_count,
                    'all_count'=>$all_count
        ]);

    }

    /**
     * Displays a single Visitor model.
     * @param integer $id
     * @return mixed
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
     * Creates a new Visitor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Visitor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Visitor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Visitor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Visitor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Visitor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Visitor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace app\controllers;

use app\components\ImageHelper;
use app\components\S3bucketHelper;
use Yii;
use app\models\HomepagePopup;
use app\models\SearchHomepagePopup;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;

/**
 * HomepagePopupController implements the CRUD actions for HomepagePopup model.
 */
class HomepagePopupController extends Controller
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
     * Lists all HomepagePopup models.
     * @return mixed
     */
    public function actionIndex()
    {
		$this->layout = 'frontend';
        $searchModel = new SearchHomepagePopup();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HomepagePopup model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HomepagePopup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HomepagePopup();
        $model->scenario = 'create';
        $date = new \DateTime();
        $domestic_airlines_image_directory = 'homepage_popup';

        if ($model->load(Yii::$app->request->post())) {
            $airlines_image = UploadedFile::getInstance($model, 'image_url');
            if (!empty($airlines_image)) {
                if (ImageHelper::ImageType($airlines_image)) {
                    $airline_image_url = S3bucketHelper::upload_aws_s3_bucket($domestic_airlines_image_directory, $airlines_image);
                    if (!empty($airline_image_url)) {
                        $airline_image_file = S3bucketHelper::homepage_popup_images($airline_image_url);
                        if (!empty($airline_image_file)) {
                            $model->image_url = $airline_image_file;
                        } else {
                            Yii::$app->session->setFlash('error', 'Image file name from s3bucket is empty');
                            return $this->redirect(['create']);
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'S3bucket object not found');
                        return $this->redirect(['create']);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Image type not supported');
                    return $this->redirect(['create']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Please Upload an Image');
                return $this->redirect(['create']);
            }
            $model->created_at = $date->format('Y-m-d H:i:s');
            $model->updated_at = $date->format('Y-m-d H:i:s');

            // setting automatic 2 month expiration date if no expire date set by admin
            if (empty($model->expire_date)) {
                $date->modify('+60 days');
                $model->expire_date = $date->format('Y-m-d');
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully Saved');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Error in saving image');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HomepagePopup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $date = new \DateTime();
        $previous_image = $model->image_url;
        $domestic_airlines_image_directory = 'homepage_popup';

        if ($model->load(Yii::$app->request->post())) {
            $airlines_image = UploadedFile::getInstance($model, 'image_url');
            if ($airlines_image != null) {
                if (ImageHelper::ImageType($airlines_image)) {
                    $airline_image_url = S3bucketHelper::upload_aws_s3_bucket($domestic_airlines_image_directory, $airlines_image);
                    if (!empty($airline_image_url)) {
                        $airline_image_file = S3bucketHelper::homepage_popup_images($airline_image_url);
                        if (!empty($airline_image_file)) {
                            $model->image_url = $airline_image_file;
                        }
                    }
                }
            } else {
                $model->image_url = $previous_image;
            }
            $model->updated_at = $date->format('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully Updated');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Error in Updating');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HomepagePopup model.
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
     * Finds the HomepagePopup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HomepagePopup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HomepagePopup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionHomepagePopupActiveAll()
    {
        $model = HomepagePopup::find()->all();
        if (!empty($model)) {
            $acitve_count = 0;
            $previous_activated = 0;
            foreach ($model as $model_item) {
                if ($model_item->status == 0) {
                    $model_item->status = 1;
                    if ($model_item->save(false)) {
                        $acitve_count++;
                    }
                } else {
                    $previous_activated++;
                }
            }
            if ($acitve_count > 0) {
                Yii::$app->session->setFlash('success', 'Successfully  Activated All Homepage Popup');
                return $this->redirect(['index']);
            } else {
                if ($previous_activated > 0) {
                    Yii::$app->session->setFlash('success', 'You have already activated ' . $previous_activated . ' Items');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'Error in Activated All');
                    return $this->redirect(['index']);
                }
            }
        } else {
            Yii::$app->session->setFlash('error', 'Homepage Popup Not found');
            return $this->redirect(['index']);
        }
    }

    public function actionHomepagePopupInactiveAll()
    {
        $model = HomepagePopup::find()->all();
        if (!empty($model)) {
            $inacitve_count = 0;
            foreach ($model as $model_item) {
                if ($model_item->status != 0) {
                    $model_item->status = 0;
                    if ($model_item->save(false)) {
                        $inacitve_count++;
                    }
                }
            }
            if ($inacitve_count > 0) {
                Yii::$app->session->setFlash('success', 'Successfully  Deactivate All Homepage Popup.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Error in Deactivate All');
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Homepage Popup Not found.');
            return $this->redirect(['index']);
        }
    }
}

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\S3bucketHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchHomepagePopup */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Homepage Popups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homepage-popup-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Homepage Popup', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Active All', ['homepage-popup-active-all'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Inactive All', ['homepage-popup-inactive-all'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Image',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Html::img(S3bucketHelper::get_storage_image_url(Yii::$app->params['homepagePopup'],$model->image_url), ['width' => '100px']), S3bucketHelper::get_storage_image_url(Yii::$app->params['homepagePopup'],$model->image_url), ['data-pjax' => 0, 'target' => '_blank']);
                },
            ],
            'image_link:ntext',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return ($model->status)?'Active':'In active';
                }
            ],
            'created_at',
            //'updated_at',
            //'expire_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

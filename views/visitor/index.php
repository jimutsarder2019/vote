<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\OrderHelper;
use kartik\date\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VisitorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//print_r($searchModel);die;
$this->title = 'Visitors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visitor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="box-footer2">
        <a href="<?php echo Url::to(['visitor/index?type=today']); ?>" class='btn btn-success'>Today (<?=@$today_count?>)</a>
        <a href="<?php echo Url::to(['visitor/index?type=month']); ?>" class='btn btn-success'>This Month (<?=@$month_count?>)</a>
        <a href="<?php echo Url::to(['visitor/index']); ?>" class='btn btn-success'>All (<?=@$all_count?>)</a>
    </div>
    
     <?= Html::beginForm(['visitor/index'.@$search_parameter], 'post', ['enctype' => 'multipart/form-data']) ?>
            <div class="box-body">
                <div class="col-lg-4">
                    <label>Date From:</label>
                    <?= DatePicker::widget([
                        'name' => 'start_date',
                        'value' => @$start_date,
                        'options' => ['autocomplete' => 'off'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]); ?>
                </div>
                <div class="col-lg-4">
                    <label>Date To:</label>
                    <?= DatePicker::widget([
                        'name' => 'end_date',
                        'value' => @$end_date,
                        'options' => ['autocomplete' => 'off'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]); ?>
                </div>
            </div>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
            <?= Html::endForm() ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            'time',
            'ip',
            'lat',
            'lng',
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}'
            ],
        ],
    ]); ?>
</div>

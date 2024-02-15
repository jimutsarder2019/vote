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
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-12">
					<div class="page-header-left">
						<h3>Visitors IP Address</h3>
						
						<div class="box-footer2">
							<a href="<?php echo Url::to(['visitor/index?type=today']); ?>" class='btn btn-success'>Today (<?=@$today_count?>)</a>
							<a href="<?php echo Url::to(['visitor/index?type=month']); ?>" class='btn btn-success'>This Month (<?=@$month_count?>)</a>
							<a href="<?php echo Url::to(['visitor/index']); ?>" class='btn btn-success'>All (<?=@$all_count?>)</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->

	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
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
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
</div>
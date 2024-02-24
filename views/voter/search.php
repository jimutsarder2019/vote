<?php

use app\models\Voter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\VoterSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'ISPAB Voter Search';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-12">
					<div class="page-header-left">
						<h3><?= Html::encode($this->title) ?></h3>
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
						<div class="user-status table-responsive2 latest-order-table">
							<div class="row">
							<div class="col-md-2"><input placeholder="Company Name" class="js_company form-control"></div>
							<div class="col-md-2"><input placeholder="Voter Name" class="js_voter form-control"></div>
							<div class="col-md-2">
							<select class="js_division form-control">
							<option value="">Division</option>
							<?php if(!empty($divisions)){  ?>
								<?php foreach($divisions as $division){  ?>
									<option value="<?=$division?>"><?=$division?></option>
								<?php } ?>
							<?php } ?>
							</select>
							</div>
							<div class="col-md-2">
								<select class="js_district form-control">
								<option value="">District</option>
								</select>
							</div>
							<div class="col-md-2">
							    <select class="js_thana form-control">
								<option value="">Thana</option>
								</select>
							</div>
							<div class="col-md-2">
								<div class="row">
								    <div class="col-md-6">
									<i data-type="search" class="btn btn-success fa fa-search js_voter_search"></i>
									</div>
									<div class="col-md-6">
									<i data-type="download" class="btn btn-success fa fa-download js_voter_search"></i>
								    </div>
								</div>
							</div>
							    </br>
							    </br>
								<div class="col-md-12 js_search_voter_data mt-3">
								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
</div>

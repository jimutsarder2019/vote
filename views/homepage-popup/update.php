<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HomepagePopup */

$this->title = 'Update Homepage Popup: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Homepage Popups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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
						   <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
</div>

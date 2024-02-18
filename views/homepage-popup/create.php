<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HomepagePopup */

$this->title = 'Create Homepage Popup';
$this->params['breadcrumbs'][] = ['label' => 'Homepage Popups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
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
			<div class="col-xl-6 xl-100">
				<div class="card">
					<div class="card-body">
						<div class="router-create">
							<?= $this->render('_form', [
								'model' => $model,
							]) ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
</div>

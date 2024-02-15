<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HomepagePopup */

$this->title = 'Update Homepage Popup: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Homepage Popups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="homepage-popup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

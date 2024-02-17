<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Voter $model */

$this->title = 'Update Voter: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Voters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="voter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

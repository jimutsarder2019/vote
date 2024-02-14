<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DocumentsType $model */

$this->title = 'Update Documents Type: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documents Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documents-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

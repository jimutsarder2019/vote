<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DocumentsType $model */

$this->title = 'Create Documents Type';
$this->params['breadcrumbs'][] = ['label' => 'Documents Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LeaveType $model */

$this->title = 'Create Leave Type';
$this->params['breadcrumbs'][] = ['label' => 'Leave Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

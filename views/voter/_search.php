<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\VoterSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="voter-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'ispab_member') ?>

    <?= $form->field($model, 'voter_no') ?>

    <?php // echo $form->field($model, 'mobile1') ?>

    <?php // echo $form->field($model, 'mobile2') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'thana') ?>

    <?php // echo $form->field($model, 'district') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'license') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

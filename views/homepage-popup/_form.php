<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HomepagePopup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="homepage-popup-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file1')->fileInput(['id' => 'homepage_popup_image', 'class' => 'form-control', 'accept' => "image/jpg,image/png,image/jpeg,image/gif"]); ?>

    <?= $form->field($model, 'image_link')->textInput() ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model,'status')->dropDownList(['1'=>'Active','0'=>'Deactive']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

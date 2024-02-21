<?php

use backend\models\EmployeeOverTime;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeOverTime */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-over-time-form">

    <p>
        <h2>Upload Csv file to insert employee attendance</h2>
    </p>
    <?php $form = ActiveForm::begin(); ?>

    <?php echo  $form->field($model, 'csv_file')->fileInput(['maxlength' => true,'class'=>'form-control','accept'=>".csv"]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

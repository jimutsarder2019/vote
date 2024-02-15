<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HomepagePopup */

$this->title = 'Create Homepage Popup';
$this->params['breadcrumbs'][] = ['label' => 'Homepage Popups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homepage-popup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

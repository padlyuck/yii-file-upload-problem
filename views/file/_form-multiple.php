<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\File */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    <?= $form->errorSummary($models)?>
    <?php foreach ($models as $i => $model): ?>
        <?= $form->field($model, "[$i]path")->fileInput() ?>
        <?= $form->field($model, "[$i]alt")->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, "[$i]title")->textInput(['maxlength' => true]) ?>
    <?php endforeach; ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

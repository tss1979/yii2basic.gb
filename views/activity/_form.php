<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\jui\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'started_at')->widget(DateTimePicker::class, [
        'language' => 'ru',
        'options' => [
            'convertFormat'=> true,
            'autocomplete'=>'off'
        ],
        'pluginOptions' => [
         'format'=> 'dd-mm-yyyy H:ii:ss',
         'startDate'=> '01-12-2019 00:00:00',
            'todayHighlight'=> true,

        ],
       ]);?>

    <?= $form->field($model,'finished_at')->widget(DateTimePicker::class, [
        'language' => 'ru',
        'options' => [
            'convertFormat'=> true,
            'autocomplete'=>'off'
        ],
        'pluginOptions' => [
            'format'=> 'dd-mm-yyyy H:ii:ss',
            'startDate'=> '01-12-2019 00:00:00',
            'todayHighlight'=> false,

        ],
    ]);?>




    <?= $form->field($model, 'main')->checkbox() ?>

    <?= $form->field($model, 'cycle')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

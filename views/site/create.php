<?php

use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->title = 'Create user';

?>
<div>
    <?= Html::a('List client', ['site/index']) ?>
</div>
<hr>
<div>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($client, 'name')->textInput() ?>
    <?= $form->field($client, 'phone')->textInput() ?>
    <?= $form->field($client, 'vat')->checkbox() ?>
    <?= $form->field($client, 'cityId')->widget(Select2::class, [
        'initValueText' => '',
        'options' => [
            'placeholder' => 'Search for a city ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['site/city-list']),
                'dataType' => 'json',
                'data' => new JsExpression('function (params) { return {q: params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function (city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
        ],
    ]) ?>
    <?= $form->field($client, 'text')->textarea() ?>
    <?= $form->field($client, 'inputLogo')->fileInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

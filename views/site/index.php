<?php

use yii\bootstrap\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'My Yii Application';

?>
<div>
    <?= Html::a('Create client', ['site/create']) ?>
</div>
<hr>
<div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'phone',
            'vat:boolean',
            [
                'attribute' => 'cityId',
                'value' => function ($model) {
                    return $model->city->name;
                },
            ],
            'text',
            [
                'attribute' => 'logoId',
                'format' => 'html',
                'value' => function ($model) {
                    return empty($model->logo) ? '' : Html::img($model->logo->src);
                },
            ],
            'createdAt:datetime',
            'updatedAt:datetime',
            [
                'class' => ActionColumn::class,
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
</div>

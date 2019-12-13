<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="activity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            [
                'attribute'=>'started_at',
                'value'=>function(\app\models\Activity $model)
                {
                    return Yii::$app->formatter->asDatetime($model->started_at);
                }
            ],
            [
                'attribute'=>'finished_at',
                'value'=>function(\app\models\Activity $model)
                {
                    return Yii::$app->formatter->asDatetime($model->finished_at);
                }
            ],
            'author_id',
            [
                'attribute'=>'main',
                'value'=>function(\app\models\Activity $model)
                {
                    return $model->main ? 'Да' : 'Нет';
                },

            ],
            [
                'attribute'=>'cycle',
                'value'=>function(\app\models\Activity $model)
                {
                    return $model->cycle ? 'Да' : 'Нет';
                },

            ],
            [
                'attribute'=>'created_at',
                'value'=>function(\app\models\Activity $model)
                {
                    return Yii::$app->formatter->asDatetime($model->started_at);
                }
            ],
            [
                'attribute'=>'updated_at',
                'value'=>function(\app\models\Activity $model)
                {
                    return Yii::$app->formatter->asDatetime($model->started_at);
                }
            ],
        ],
    ]) ?>

</div>

<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Activity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            [
                'attribute'=>'started_at',
                'filter'=>\kartik\date\DatePicker::widget([
                    'model'=>$model,
                    'attribute'=>'started_at',
                    'language'=>'ru',
                    'pluginOptions'=>[
                        'autoclose'=> true,
                        'todayHighlight'=>true,
                        'format'=>'dd.mm.yyyy',
                    ],
                ]),
                'value'=>function(\app\models\Activity $model)
                {
                    return Yii::$app->formatter->asDatetime($model->started_at);
                }

            ],
            [
                'attribute'=>'finished_at',
                'filter'=>\kartik\date\DatePicker::widget([
                    'model'=>$model,
                    'attribute'=>'finished_at',
                    'language'=>'ru',
                    'pluginOptions'=>[
                        'autoclose'=> true,
                        'todayHighlight'=>true,
                        'format'=>'dd.mm.yyyy',
                    ],
                ]),
                'value'=>function(\app\models\Activity $model)
                {
                    return Yii::$app->formatter->asDatetime($model->finished_at);
                }

            ],
            /* [
                    'attribute'=>'authorEmail',
                    'format' => 'raw',
                    'value'=>function(\app\models\User $model)
                    {
                        return Html::a($model->email, ['/user/view', 'id'=>$model->id]);
                    }

                ],*/
            'author_id',
            //'main',
            //'cycle',
            //'created_at',
            //'updated_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
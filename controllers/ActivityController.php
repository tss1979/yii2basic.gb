<?php

namespace app\controllers;

use Yii;
use app\models\Activity;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\QueryBuilder;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\UploadedFile;

class ActivityController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class, //ACF
                //'only' => ['index', 'view', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'submit'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex($sort = false) {

        $query = Activity::find()->where(['author_id'=>Yii::$app->user->identity->getId()]);
        $model = Activity::find()->where(['author_id'=>Yii::$app->user->identity->getId()]);
        var_dump($model);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        /*$provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'validatePage' => false,
                'pageSize' => 5,
            ]
        ]);*/
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
        //return $this->render('index', ['provider' => $provider, 'model' => $model]);
    }

    public function actionView(int $id) {

        $model = Activity::findOne($id);
        return $this->render('view',
            compact('model'));
    }
    public function actionCreate(){
        $model = new Activity();
        $model->save();
        return $this->render('create',
            ['model' => $model]
        );
    }
    public function actionUpdate(int $id = null)
    {

        if(!empty($id)){
            $model = Activity::findOne($id);
             if(Yii::$app->user->identity->getId() === $model->author_id) {
                 $this->render('update', [
                     'model' => $model]);
                 if ($model->load(Yii::$app->request->post()) and $model->validate()) {
                     if ($model->save()) {
                         return $this->redirect(["activity/view?id=$model->id"]);
                     }
                 }
             }
        }
    }

    public function actionDelete(int $id = null)
    {

        if(!empty($id)){
            $model = Activity::findOne($id);
            if(Yii::$app->user->identity->getId() === $model->author_id) {
                if ($model->load(Yii::$app->request->post()) and $model->validate()) {
                    if ($model->delete()) {
                        return $this->redirect(["activity/view?id=$model->id"]);
                    }
                }
            }
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    public function actionSubmit() {
        $model = new Activity();
        if($model->load(Yii::$app->request->post())) {
            if ($model->save() ) {
                return 'Success: ' . VarDumper::export($model->attributes);
            } else {
                return 'Failed: ' . VarDumper::export($model->errors);
            }
        }
        return 'Activity@Submit';
    }

}
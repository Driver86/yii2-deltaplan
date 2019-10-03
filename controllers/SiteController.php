<?php

namespace app\controllers;

use app\models\City;
use app\models\Client;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Client::find(),
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
            ],
            'pagination' => [
                'defaultPageSize' => 100,
                'pageSizeParam' => false,
            ],
        ]);
        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $client = new Client();

        if (!$client) {
            throw new NotFoundHttpException();
        }

        if ($client->load(Yii::$app->request->post()) and $client->save()) {
            return $this->redirect(['index']);
        }

        return $this->render($this->action->id, [
            'client' => $client,
        ]);
    }

    public function actionUpdate($id)
    {
        $client = Client::findOne($id);

        if (!$client) {
            throw new NotFoundHttpException();
        }

        if ($client->load(Yii::$app->request->post()) and $client->save()) {
            return $this->refresh();
        }

        return $this->render($this->action->id, [
            'client' => $client,
        ]);
    }

    public function actionDelete($id)
    {
        $client = Client::findOne($id);

        if (!$client) {
            throw new NotFoundHttpException();
        }

        $client->delete();

        return $this->redirect(['index']);
    }

    public function actionCityList($q = null, $id = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query();
            $query->select('id, name as text')
                ->from('city')
                ->where(['like', 'name', $q])
                ->orderBy('name asc')
                ->limit(30);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => City::findOne($id)->name];
        }
        return $out;
    }
}

<?php

namespace frontend\controllers;

use common\models\Video;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class VideoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->published()->latest()
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Function to view a single video
     */
    public function actionView($id)
    {
        $this->layout = 'auth';
        $video = video::findOne($id);
        if(!$video){
            throw new NotFoundHttpException("The videos not exist");
        }

        return $this->render('view', [
            'model' => $video
        ]);
    }

}

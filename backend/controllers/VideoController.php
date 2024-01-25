<?php

namespace backend\controllers;

use common\models\video;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * VideoController implements the CRUD actions for video model.
 */
class VideoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all video models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => video::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'video_id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single video model.
     * @param string $video_id Video ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($video_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($video_id),
        ]);
    }

    /**
     * Creates a new video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new video();
        
        $model->video = UploadedFile::getInstanceByName('video');
        
        if ($this->request->isPost) {
            if (Yii::$app->request->isPost && $model->save()) {
                return $this->redirect(['update', 'video_id' => $model->video_id]);
            }
        } 
        // else {
        //     $model->loadDefaultValues();
        // }
            // dump($model->load($this->request->post()));
            // exit;
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $video_id Video ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($video_id)
    {
        $model = $this->findModel($video_id);

        $model->thumbnail = UploadedFile::getInstancesByName('thumbnail');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['update', 'video_id' => $model->video_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing video model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $video_id Video ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($video_id)
    {
        $this->findModel($video_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $video_id Video ID
     * @return video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($video_id)
    {
        if (($model = video::findOne(['video_id' => $video_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

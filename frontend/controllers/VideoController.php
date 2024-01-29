<?php

namespace frontend\controllers;

use common\models\Video;
use common\models\VideoLike;
use common\models\VideoView;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class VideoController extends \yii\web\Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['like', 'dislike'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@']
                        ]
                    ]
                ],
                'verb' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'like' => ['post'],
                        'dislike' => ['post'],
                    ],
                ],
            ]
        );
    }

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
        $video = $this->findVideo($id);
        // Saving the video to video_view
        $videoView = new VideoView();
        $videoView->video_id = $id;
        $videoView->user_id = Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();
        return $this->render('view', [
            'model' => $video
        ]);
    }

    /**
     * Function to handle the action to like the video
     */
    public function actionLike($video_id)
    {
        $video = $this->findVideo($video_id);
        $userId = Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()->userIdVideoId($userId, $video_id);
        if(!$videoLikeDislike){
            $this->saveLikeDislike($video_id, $userId, VideoLike::TYPE_LIKE);
        }else if ($videoLikeDislike->type == VideoLike::TYPE_LIKE) {
            $videoLikeDislike->delete();
        }else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($video_id, $userId, VideoLike::TYPE_LIKE);
        }

        return $this->renderAjax('_like_dislike_buttons', [
            'model' => $video
        ]);
    }

    /**
     * Function to dislike the video
     */
    public function actionDislike($video_id)
    {
        $video = $this->findVideo($video_id);
        $userId = Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()->userIdVideoId($userId, $video_id);
        if(!$videoLikeDislike){
            $this->saveLikeDislike($video_id, $userId, VideoLike::TYPE_DISLIKE);
        }else if ($videoLikeDislike->type == VideoLike::TYPE_DISLIKE) {
            $videoLikeDislike->delete();
        }else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($video_id, $userId, VideoLike::TYPE_DISLIKE);
        }

        return $this->renderAjax('_like_dislike_buttons', [
            'model' => $video
        ]);
    }

    /**
     * Function to find the id
     */
    protected function findVideo($video_id)
    {
        $video = video::findOne($video_id);
        if(!$video){
            throw new NotFoundHttpException("The videos not exist");
        }
    
        return $video;
    }

    /**
     * Function to save the updates to the database for like or dislike
     */
    protected function saveLikeDislike($videoId, $userId, $type)
    {
        $videoLikeDislike = new VideoLike();
        $videoLikeDislike->video_id = $videoId;
        $videoLikeDislike->user_id = $userId;
        $videoLikeDislike->type = $type;
        $videoLikeDislike->created_at = time();
        $videoLikeDislike->save();
    }

}

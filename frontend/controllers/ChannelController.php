<?php

namespace frontend\controllers;

use app\models\Subscriber;
use yii\web\NotFoundHttpException;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ChannelController extends \yii\web\Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['subscribe', 'unsubscribe'],
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
                        'subscribe' => ['post'],
                        'unsubscribe' => ['post'],
                    ],
                ],
            ]
        );
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($username)
    {
        $channel = $this->findChannel($username);
        return $this->render('view', [
            'channel' => $channel
        ]);
    }

    protected function findChannel($username)
    {
        $channel = User::findByUsername($username);
        if(!$channel) {
            throw new NotFoundHttpException("Cannot find this channel");
        }
        return $channel;
    }

    public function actionSubscribe($username)
    {
        $channel = $this->findChannel($username);
        $userId = Yii::$app->user->id;
        $subscriber = $channel->isSubscribed($userId);
        if(!$subscriber){
            $subscriber = new Subscriber();
            $subscriber->channel_id = $channel->id;
            $subscriber->user_id = $userId;
            $subscriber->created_at = time();
            $subscriber->save();
        }else{
            $subscriber->delete();
        }
        
        return $this->renderAjax('_subscribe', [
            'channel' => $channel
        ]);
    }

}

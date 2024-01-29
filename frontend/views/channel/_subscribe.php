<?php
use yii\helpers\Url;
/**
 * @var common\models\User $channel
 */

 ?>
 <a href="<?php echo Url::to(['channel/subscribe', 'username' => $channel->username]) ?>"
     class="btn <?php echo $channel->isSubscribed(Yii::$app->user->id) 
     ? "btn-secondary" : "btn-danger" ?>" data-method='post' data-pjax="1">
     Subscribe <i class="fa fa-bell" aria-hidden="true"></i>
    </a> <?php echo $channel->getSubscribers()->count() ?>
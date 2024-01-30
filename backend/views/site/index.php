<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

/**
 * @var common\models\Video $latestVideo
 * @var integer $numberOfView
 * @var integer $numberOfSubscribers
 * @var common\models\Subscriber[] $subscribers
 */

$this->title = 'My Yii Application';
?>
<div class="site-index d-flex">
    <?php if ($latestVideo): ?>
        <div class="card m-2" style="width: 18rem;">
            <div class="embed-responsive embed-responsive-16by9 mb-3">
                <video class="embed-responsive-item" poster="<?php echo $latestVideo->getThumbnailLink() ?>" src="<?php echo $latestVideo->getVideoLink() ?>"controls width="250"></video>
            </div>
            <div class="card-body">
                <h6 class="card-title"><?php echo $latestVideo->title ?></h6>
                <p class="card-text">
                    Likes: <?php echo $latestVideo->getLikes()->count() ?>
                    Views: <?php echo $latestVideo->getViews()->count() ?>
                </p>
                <a href="<?php echo Url::to(['/video/update' , 'video_id' => $latestVideo->video_id]) ?>" class="btn btn-primary">Edit</a>
            </div>
        </div>
        <div class="card m-2" style="width: 14rem; font-size: 48px">
            <div class="card-body">
                <h6 class="card-title">Total Views</h6>
                <p class="card-text">
                    <?php echo $numberOfView ?>
                </p>
            </div>
        </div>
    <?php else: ?>
        <div class="card-body">
            You don't have uploaded videos yet
        </div>
    <?php endif ?>
    <div class="card m-2" style="width: 14rem; font-size: 48px">
        <div class="card-body">
            <h6 class="card-title">Total Subscribers</h6>
            <p class="card-text">
                <?php echo $numberOfSubscribers ?>
            </p>
        </div>
    </div>
    <div class="card m-2" style="width: 14rem; font-size: 48px">
        <div class="card-body">
            <h6 class="card-title">Latest Subscribers</h6>
            <?php foreach($subscribers as $subscriber): ?>
                <div><?php echo $subscriber->user->username ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

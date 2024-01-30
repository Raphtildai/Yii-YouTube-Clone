<?php 
/**
 * @var $model \common\models\video
 */

use yii\helpers\StringHelper;
use yii\helpers\Url;
use common\helpers\HtmlLink;

?>
<div class="card m-3" style="width: 14rem;">
    <a href="<?php echo Url::to(['/video/view', 'video_id' => $model->video_id], $schema = true)?>">
        <div class="embed-responsive embed-responsive-16by9">
            <video class="card-img-top embed-responsive-item" poster="<?php echo $model->getThumbnailLink() ?>" src="<?php echo $model->getVideoLink() ?>" width="250"></video>
        </div>
    </a>
    <div class="text-muted card-body p-2">
        <h6 class="card-title m-0"><?php echo $model->title ?></h6>
        <p class="text-muted card-text m-0">
            <?php echo HtmlLink::channelLink($model->createdBy) ?>
        </p>
        <p class="text-muted card-text m-0">
            <?php echo StringHelper::truncateWords($model->description, 5, $suffix = '...', $asHtml = true) ?>
        </p>
        <p class="text-muted card-text m-0">
        <?php echo $model->getViews()->count() ?> views • <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </p>
    </div>
</div>
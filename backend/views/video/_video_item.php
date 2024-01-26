<?php 
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * This is the file to render the video in the studio
 * @var $model \common\models\video
 */
?>
<div class="d-flex">
    <a href="<?php echo Url::to(['/video/update', 'video_id' => $model->video_id]) ?>">
        <div class="flex-shrink-0">
            <video class="embed-responsive-item" poster="<?php echo $model->getThumbnailLink() ?>" src="<?php echo $model->getVideoLink() ?>"width="200px" height="100" ></video>
        </div>
    </a>
  <div class="flex-grow-1 ms-3">
    <h6 class="mt-0"><?php echo $model->title ?></h6><br>
    <?php echo StringHelper::truncateWords($model->description, 10, $suffix = '...', $asHtml = true) ?>
  </div>
</div>
<?php

use yii\helpers\Url;

/**
 * @var $model \common\models\video
 */

?>
<a href="<?php echo Url::to(['/video/like', 'video_id' => $model->video_id], $schema = true) ?>"
    class="btn btn-sm <?php echo $model->isLikedBy(Yii::$app->user->id) ? 'btn-outline-primary' : 'btn-outline-secondary'; ?>" data-method="post" data-pjax="1">
    <i class="fa fa-thumbs-up" aria-hidden="true"></i> <?php echo $model->getLikes()->count() ?>
</a>
<a href="<?php echo Url::to(['/video/dislike', 'video_id' => $model->video_id], $schema = true) ?>"
    class="btn btn-sm <?php echo $model->isDisLikedBy(Yii::$app->user->id) ? 'btn-outline-primary' : 'btn-outline-secondary'; ?>" data-method="post" data-pjax="1">
    <i class="fa fa-thumbs-down" aria-hidden="true"></i> <?php echo $model->getDisLikes()->count() ?>
</a>
<?php

use common\helpers\HtmlLink;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/**
 * @var $model \common\models\video
 * @var $similarVideos common\models\Video 
 */
?>
<div class="row">
    <div class="col-sm-8">
        <div class="embed-responsive embed-responsive-16by9">
            <video class="card-img-top ratio ratio-21x9" 
                poster="<?php echo $model->getThumbnailLink() ?>" 
                src="<?php echo $model->getVideoLink() ?>" 
                controls width="50">
            </video>
        </div>
        <h6 class="mt-2"><?php echo $model->title ?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <?php echo $model->getViews()->count() ?> views • <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <?php Pjax::begin() ?>
                    <?php echo $this->render('_like_dislike_buttons', [
                        'model' => $model
                    ]) ?>
                <?php Pjax::end() ?>
            </div>
        </div>
        <div>
            <p><?php echo HtmlLink::channelLink($model->createdBy) ?></p>
            <?php echo Html::encode($model->description) ?>
        </div>
    </div>
    <div class="col-sm-4">
        <?php foreach ($similarVideos as $similarVideo): ?>
            <div class="d-flex">
                <a href="<?php echo Url::to(['/video/view', 'video_id' => $similarVideo->video_id], $schema = true) ?>">
                    <div class="flex-shrink-0">
                        <div class="embed-responsive embed-responsive-16by9 mr-2 mb-2" style="width: 200px;">
                            <video class="card-img-top embed-responsive-item" 
                                poster="<?php echo $similarVideo->getThumbnailLink() ?>" 
                                src="<?php echo $similarVideo->getVideoLink() ?>">
                            </video>
                        </div>
                    </div>
                </a>
                    
                <div class="flex-grow-1 ms-3 text-muted">
                    <h6><?php echo $similarVideo->title ?></h6>
                    <p class="m-0">
                        <?php echo HtmlLink::channelLink($similarVideo->createdBy) ?>
                    </p>
                    <small>
                        <?php echo $similarVideo->getViews()->count() ?> views • <?php echo Yii::$app->formatter->asRelativeTime($similarVideo->created_at) ?>
                    </small>
                </div> 
             </div>
        <?php endforeach; ?>
    </div>
</div>
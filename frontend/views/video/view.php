<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/**
 * @var $model \common\models\video
 */
?>
<div class="row">
    <div class="col-sm-8">
        <div class="embed-responsive embed-responsive-16by9">
            <video class="card-img-top embed-responsive-item" 
                poster="<?php echo $model->getThumbnailLink() ?>" 
                src="<?php echo $model->getVideoLink() ?>" 
                controls width="250">
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
            <p><?php echo Html::a($model->createdBy->username, [
                '/channel/view', 'username' => $model->createdBy->username
            ]) ?></p>
            <?php echo Html::encode($model->description) ?>
        </div>
    </div>
    <div class="col-sm-4">

    </div>
</div>
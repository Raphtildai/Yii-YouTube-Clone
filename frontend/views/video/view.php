<?php
/**
 * @var $model \common\models\video
 */
?>
<div class="row">
    <div class="col-sm-8">
        <div class="embed-responsive embed-responsive-16by9">
            <video class="card-img-top embed-responsive-item" poster="<?php echo $model->getThumbnailLink() ?>" src="<?php echo $model->getVideoLink() ?>" controls width="250"></video>
        </div>
        <h6 class="mt-2"><?php echo $model->title ?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div>
            123views • <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i> 9
                </button>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-thumbs-down" aria-hidden="true"></i> 3
                </button>
            </div>
        </div>
    </div>
    <div class="col-sm-4">

    </div>
</div>
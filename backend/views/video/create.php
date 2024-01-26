<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\video $model */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="upload-icon">
            <i class="fa fa-upload" aria-hidden="true"></i>
        </div>
        <br>
        <p class="m-o">Drag and drop a file you want to upload</p>
        <p class="text-muted">Your video will be private until you publish it</p>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]) ?>
        <!-- Outputting the errors -->
        <?php echo $form->errorSummary($model); ?>

        <button class="btn btn-primary btn-file">
            Select File
            <input type="file" id="videoFile" name="video">
        </button>

        <?php ActiveForm::end() ?>
    </div>

</div>

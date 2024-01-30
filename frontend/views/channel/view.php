<?php 
/**
 * @var yii\web\View $this
 * @var common\models\User $channel
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use common\widgets\getListView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;

?>

<div class="mt-4 p-5 bg-light text-primary rounded">
  <h1 class="display-4"><?php echo $channel->username ?></h1>
  <hr class="my-4">
  <?php Pjax::begin() ?>
    <?php echo $this->render('_subscribe', [
        'channel' => $channel
    ]) ?>
  <?php Pjax::end() ?>
</div>
<?php

 echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '@frontend/views/video/_video_item',
    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false
    ]
 ])
?>
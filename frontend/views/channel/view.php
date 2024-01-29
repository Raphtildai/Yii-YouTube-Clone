<?php 
/**
 * @var yii\web\View $this
 * @var common\models\User $channel
 */

use yii\helpers\Url;
use yii\widgets\Pjax;

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
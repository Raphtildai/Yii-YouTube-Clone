<?php 
/**
 * @var common\models\User $channel 
 * @var common\models\User $user 
 */

use common\helpers\HtmlLink;

?>

<p>Hello <?php echo $channel->username ?></p>
<p>User <?php echo HtmlLink::channelLink($user, true) ?> has subscribed to you</p>
<p>YouTube Clone Team</p>
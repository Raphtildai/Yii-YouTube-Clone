<?php
/**
 * 
 * This is the content of the sidebar
 */

 use \yii\bootstrap5\Nav;
?>

<aside class="shadow h-100">
    <?php 
    echo Nav::widget([
        'options' => [
            'class' => 'nav-pills d-flex flex-column'
        ],
        'items' => [
            [
                'label' => 'Dashboard',
                'url' => ['/site/index']
            ],
            [
                'label' => 'Videos',
                'url' => ['/video/index']
            ]
        ]
    ])
    ?>
</aside>
<!-- <div class="list-group">
  <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
    The current link item
  </a>
  <a href="#" class="list-group-item list-group-item-action">A second link item</a>
  <a href="#" class="list-group-item list-group-item-action">A third link item</a>
  <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
  <a class="list-group-item list-group-item-action disabled" aria-disabled="true">A disabled link item</a>
</div> -->
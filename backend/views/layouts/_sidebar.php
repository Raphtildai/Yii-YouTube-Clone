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
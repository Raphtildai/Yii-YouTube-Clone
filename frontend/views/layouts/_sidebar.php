<?php
/**
 * 
 * This is the content of the frontend sidebar
 */

 use \yii\bootstrap5\Nav;
?>

<aside class="shadow">
    <?php 
    echo Nav::widget([
        'options' => [
            'class' => 'nav-pills d-flex flex-column'
        ],
        'items' => [
            [
                'label' => 'Home',
                'url' => ['/video/index']
            ],
            [
                'label' => 'History',
                'url' => ['/video/history']
            ]
        ]
    ])
    ?>
</aside>
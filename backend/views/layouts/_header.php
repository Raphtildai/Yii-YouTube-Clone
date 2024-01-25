<?php
/**
 * This is the header contents for the backend layout
 * 
 */
    use yii\bootstrap5\Html;
    use yii\bootstrap5\Nav;
    use yii\bootstrap5\NavBar;

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'shadow-sm navbar navbar-expand-md navbar-light bg-light fixed-top',
        ],
    ]);
    $menuItems = [
        // ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    }     
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {
        $menuItems = [
            ['label' => 'Create', 'url' => ['/video/create']],
        ];
        $menuItems[] = [
            'label' => 'Logout ('. Yii::$app->user->identity->username .')',
            'url' => ['/site/logout'],
            'linkOptions' => [
                'data-method' => 'post'
            ]
        ];
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ml-auto'],
            'items' => $menuItems
        ]);
    }
    
    NavBar::end();
?>
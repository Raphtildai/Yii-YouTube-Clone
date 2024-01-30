<?php
/**
 * This is the header contents for the frontend layout
 * 
 */
    use yii\bootstrap5\Html;
    use yii\bootstrap5\Nav;
    use yii\bootstrap5\NavBar;
use yii\helpers\Url;

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    $menuItems[] = '';
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ml-auto mb-2 mb-md-0'],
            'items' => $menuItems,
        ]);
    }

    if (!Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => [
                'data-method' => 'post'
            ]
            ];
            ?>
            <form class="d-flex" action="<?php echo Url::to(['/video/search']) ?>">
                <input class="form-control me-2" type="search" placeholder="Search" name="keyword"
                <?php echo Yii::$app->request->get('keyword') ?>>
                <button class="btn btn-outline-success">Search</button>
            </form>
            <?php
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav ml-auto mb-2 mb-md-0'],
                'items' => $menuItems,
            ]);
    } 
    NavBar::end();
?>
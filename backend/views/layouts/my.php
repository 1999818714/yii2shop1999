<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '我的博客就是我的',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['admin/index']],
//        ['label' => '权限管理',
//            'items' => [
//                ['label' => '权限管理列表', 'url' => ['rbac/permission-index']],
//                ['label' => '添加权限', 'url' => ['rbac/add-permission']],
//            ],
//        ],
//        ['label' => '角色管理',
//            'items' => [
//                ['label' => '角色管理列表', 'url' => ['rbac/role-index']],
//                ['label' => '添加角色', 'url' => ['rbac/add-role']],
//            ],
//        ],
//        ['label' => '品牌',
//            'items' => [
//                ['label' => '品牌列表', 'url' => ['brand/index']],
//                ['label' => '添加品牌', 'url' => ['brand/add']],
//            ],
//        ],
//        [ 'label' => '商品管理',
//            'items' => [
//                ['label' => '商品分类', 'url' => ['goods-category/index']],
//                ['label' => '商品列表', 'url' => ['goods/index']],
//                ['label' => '添加商品', 'url' => ['goods/add']],
//            ],
//        ],
//        [ 'label' => '文章管理',
//            'items' => [
//                ['label' => '文章分类', 'url' => ['article-category/index']],
//                ['label' => '添加文章分类', 'url' => ['article-category/add']],
//                ['label' => '文章列表', 'url' => ['article/index']],
//                ['label' => '添加文章', 'url' => ['article/add']],
//            ],
//        ],
//        ['label' => '管理员',
//            'items' => [
//              ['label'=> '管理员列表', 'url' => ['admin/index']],
//              ['label'=> '添加管理员', 'url' => ['admin/add']],
//            ],
//         ],
//        'url' => ['menu/add'];//菜单管理
//        ['label' => '别!别点我!点了你会后悔的!', 'url' => ['/site/index']],
//        ['label' => 'About', 'url' => ['/site/about']],
//        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];

    if (Yii::$app->user->isGuest) {
    //判断是否登陆,而显视登陆或退出
            $menuItems[] = [
                'label' => '未登录',
                'items' => [
                    ['label'=> '登录','url' => ['admin/login']]
                ],
            ];
    } else {
        //获取当前用户对应的菜单
        $menuItems = \yii\helpers\ArrayHelper::merge($menuItems,Yii::$app->user->identity->getMenuItems());
        $menuItems[] = '<li>'
            . Html::beginForm(['/admin/logout'], 'post')
            . Html::submitButton(
                '退出登录 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">PHP学习网站</p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

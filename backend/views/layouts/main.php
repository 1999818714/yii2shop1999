<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '主页', 'url' => ['/site/index']],
        ['label' => '品牌',
            'items' => [
                ['label' => '品牌列表', 'url' => ['brand/index']],
                ['label' => '添加品牌', 'url' => ['brand/add']],
            ],
        ],
        [ 'label' => '商品管理',
            'items' => [
                ['label' => '商品分类', 'url' => ['goods-category/index']],
                ['label' => '商品列表', 'url' => ['goods/index']],
                ['label' => '添加商品', 'url' => ['goods/add']],
            ],
        ],
        [ 'label' => '文章管理',
            'items' => [
                ['label' => '文章分类', 'url' => ['article-category/index']],
                ['label' => '添加文章分类', 'url' => ['article-category/add']],
                ['label' => '文章列表', 'url' => ['article/index']],
                ['label' => '添加文章', 'url' => ['article/add']],
            ],
        ],
        ['label' => '管理员',
            'items' => [
              ['label'=> '管理员列表', 'url' => ['admin/index']],
              ['label'=> '添加管理员', 'url' => ['admin/add']],
            ],
         ],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = [
             'label' => '未登录',
            'items' => [
                ['label'=> '登录','url' => ['admin/login']]
            ],
        ];
    } else {
        $menuItems[] = [
            'label' => '当前用户 (' . Yii::$app->user->identity->username . ')',
            'items' => [
                ['label'=> '退出登录','url' => ['admin/logout']],
                ['label'=> '修改密码','url' => ['admin/pass?id='.Yii::$app->user->id]]
            ],
        ];
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/admin/logout'], 'post')
//            . Html::submitButton(
//                '退出登录 (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link logout']
//            )
//            . Html::endForm()
//            . '</li>';
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
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

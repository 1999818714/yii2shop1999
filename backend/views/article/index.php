<a class="btn btn-primary" href="<?php echo \yii\helpers\Url::to(['article/add'])?>">添加文章</a>
<table class="table table-bordered table-condensed">
    <tr>
        <th>id</th>
        <th>名称</th>
        <th>简介</th>
        <th>文章分类id</th>
        <th>排序</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>
            <td><?=\backend\models\Article::getNameById($model->article_category_id)?></td>
            <td><?=$model->sort?></td>
            <td><?=$model->is_deleted==0? '正常' : '删除'?></td>
            <td><?=$model->create_time?></td>
            <td><a class="btn btn-info" href="<?php echo \yii\helpers\Url::to(['article/edit?id='.$model->id])?>">修改</a>
                <a class="btn btn-danger" href="<?php echo \yii\helpers\Url::to(['article/del?id='.$model->id])?>">删除</a></td>
        </tr>
    <?php endforeach; ?>
</table>
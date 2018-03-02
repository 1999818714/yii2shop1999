<a class="btn btn-primary" href="<?php echo \yii\helpers\Url::to(['goods-category/add'])?>">添加商品分类</a>
<table class="table table-bordered table-condensed">
    <tr>
        <th>id</th>
        <th>上级分类id</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->parent_id?></td>
            <td><?=$model->intro?></td>
            <td><a class="btn btn-info" href="<?php echo \yii\helpers\Url::to(['goods-category/edit?id='.$model->id])?>">修改</a>
                <a class="btn btn-danger" href="<?php echo \yii\helpers\Url::to(['goods-category/del?id='.$model->id])?>">删除</a></td>
        </tr>
    <?php endforeach; ?>
</table>
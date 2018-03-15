<?php
echo \yii\bootstrap\Html::a('添加',['menu/add'],['class'=>'btn btn-info'])
/* @var $this yii\web\View */
?>
<h1>menu/index</h1>

<table class="table">
        <tr>
            <th>名称</th>
            <th>路由</th>
            <th>操作</th>
        </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->parent_id>0?'--'.$model->name:''.$model->name?></td>
            <td><?=$model->url?></td>
            <td><?=\yii\bootstrap\Html::a('删除',['menu/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('修改',['menu/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
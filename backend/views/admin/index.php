<?=\yii\bootstrap\Html::a('添加(注册)管理员',['admin/add'],['class'=>'btn btn-primary']);?>
<?=\yii\bootstrap\Html::a('管理员(不可用)',['admin/recycler'],['class'=>'btn btn-primary']);?>
<!--       白色，浅蓝色，      深蓝色，     绿色，          黄色，          红色，          黑色-->
<!--颜色   btn,btn btn-primary,btn btn-info,btn btn-success,btn btn-warning,btn btn-danger,btn btn-inverse-->
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>邮箱</th>
        <th>添加(注册)时间</th>
        <th>修改时间</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->username?></td>
            <td><?=$model->email?></td>
            <td><?=date('Y-m-d H:i:s',$model->created_at)?></td>
            <td><?=date('Y-m-d H:i:s',$model->updated_at)?></td>
            <td><?=date('Y-m-d H:i:s',$model->last_login_time)?></td>
            <td><?=$model->last_login_ip?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['admin/edit','id'=>$model->id],['class'=>'btn btn-primary'])?>
                <?=\yii\bootstrap\Html::a('删除',['admin/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('重置密码',['admin/rep','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'hideOnSinglePage'=>0
]);
?>

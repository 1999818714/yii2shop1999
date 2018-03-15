<?=\yii\bootstrap\Html::a('添加(注册)',['member/register'],['class'=>'btn btn-primary']);?>
<!--       白色，浅蓝色，      深蓝色，     绿色，          黄色，          红色，          黑色-->
<!--颜色   btn,btn btn-primary,btn btn-info,btn btn-success,btn btn-warning,btn btn-danger,btn btn-inverse-->
<!--<div class="login_form fl">-->
<table class="table table-bordered table-condensed">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>手机号</th>
        <th>邮箱</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->username?></td>
            <td><?=$model->tel?></td>
            <td><?=$model->email?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['member/edit','id'=>$model->id],['class'=>'btn btn-primary'])?>
                <?=\yii\bootstrap\Html::a('删除',['member/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<!--</div>-->

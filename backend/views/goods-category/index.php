<a class="btn btn-primary" href="<?php echo \yii\helpers\Url::to(['goods-category/add'])?>">添加商品分类</a>
<table class="table table-bordered table-condensed">
    <tr>
        <th>id</th>
        <th>上级分类id</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>" data-tree="<?=$model->tree?>">
            <td><?=$model->id?></td>
            <td><?=str_repeat('－',$model->depth).$model->name?><span class="glyphicon glyphicon-chevron-up expand" style="float: right"></span></td>
            <td><?=$model->intro?></td>
            <td><?=\yii\bootstrap\Html::a('编辑',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$model->id],['class'=>'btn btn-info'])?></td>
        </tr>
    <?php endforeach;?>
</table>
<?php
$js=<<<EOT
    $(".expand").click(function(){
        $(this).toggleClass("glyphicon-chevron-up");
        $(this).toggleClass("glyphicon-chevron-down");

        var tr = $(this).closest("tr");
        var p_lft = parseInt(tr.attr("data-lft"));
        var p_rgt = parseInt(tr.attr("data-rgt"));
        var p_tree= parseInt(tr.attr("data-tree"));

        $("tbody tr").each(function(){
            var lft = parseInt($(this).attr("data-lft"));
            var rgt = parseInt($(this).attr("data-rgt"));
            var tree = parseInt($(this).attr("data-tree"));

            if(tree == p_tree &&　lft>p_lft && rgt<p_rgt){
                $(this).fadeToggle();
            }
        });
    });
EOT;

$this->registerJs($js);
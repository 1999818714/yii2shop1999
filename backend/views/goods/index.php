<?=\yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-info'])?>
<?=\yii\bootstrap\Html::a('首页',['goods/index'],['class'=>'btn btn-info'])?>
<?=\yii\bootstrap\Html::a('回收站',['goods/recycler'],['class'=>'btn btn-danger'])?>
<?php
//echo '<pre>';
$form = \yii\bootstrap\ActiveForm::begin([
    'method'=>'get',
    'action'=>\yii\helpers\Url::to(['goods/index']),
    'options'=>[
        'class'=>'form-inline']
]);
echo $form->field($model,'name');
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-success','goods/sou']);
\yii\bootstrap\ActiveForm::end();
//?>
<!--<form action="index.php">-->
<!--    <input type="text" value="" id="name">-->
<!--    <input type="submit" value="搜索">-->
<!--</form>-->
    <table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>货号</th>
        <th>LOGO</th>
        <th>商品分类</th>
        <th>品牌</th>
        <th>市场价格</th>
        <th>本店价格</th>
        <th>库存</th>
        <th>是否上架</th>
        <th>状态</th>
        <th>排序</th>
        <th>录入时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->sn?></td>
            <td><?=\yii\bootstrap\Html::img($model->logo,['style'=>'width:50px'])?></td>
            <td><?=\backend\models\Goods::getGoodsCategoryById($model->goods_category_id)?></td>
            <td><?=\backend\models\Goods::getBrandById($model->brand_id)?></td>
            <td><?=$model->market_price?></td>
            <td><?=$model->shop_price?></td>
            <td><?=$model->stock?></td>
            <td><?=$model->is_on_sale==1 ? '在售' : '下架'?></td>
            <td><?=$model->status==1 ? '正常' : '回收站'?></td>
            <td><?=$model->sort?></td>
            <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>

            <?php
                if($model->status==1){
            ?>
                <td><?=\yii\bootstrap\Html::a('编辑',['goods/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
                <?=\yii\bootstrap\Html::a('查看',['goods/look','id'=>$model->id],['class'=>'btn btn-info'])?></td>
            <?php
                }else{
            ?>
                    <td><?=\yii\bootstrap\Html::a('恢复',['goods/no-del','id'=>$model->id],['class'=>'btn btn-danger'])?></td>
            <?php
                    }
                ?>
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
<script type="text/javascript" src="/zTree/api/apiCss/jquery-1.6.2.min.js"></script>
<script type="text/javascript">

</script>

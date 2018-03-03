<html xmlns="http://www.w3.org/1999/html">
<br>
<h2>
    <p>商品名称：<?=$model->name?></p>
    浏览量：<?=$model->view_times?><br>
</h2>
<div>
    货号:<?=$model->sn?><br>
    商品分类:<?=\backend\models\Goods::getGoodsCategoryById($model->goods_category_id)?><br>
    品牌分类:<?=\backend\models\Goods::getBrandById($model->brand_id)?><br>
    市场价格:<?=$model->market_price?><br>
    商品价格:<?=$model->shop_price?><br>
    库存:<?=$model->stock?><br>
    是否在售:<?=$model->is_on_sale==1 ? '在售' : '下架'?><br>
    状态:<?=$model->status==1 ? '正常' : '回收站'?><br>
    排序:<?=$model->sort?><br>
    添加时间:<?=date('Y-m-d H:i:s',$model->create_time)?><br>
    商品内容:<?=$intro->content?><br>
    商品图片:<?=\yii\bootstrap\Html::img($model->logo,['style'=>'width:200px'])?>

    <!--    name	varchar(20)	商品名称-->
<!--    sn	varchar(20)	货号-->
<!--    logo	varchar(255)	LOGO图片-->
<!--    goods_category_id	int	商品分类id-->
<!--    brand_id	int	品牌分类-->
<!--    market_price	decimal(10,2)	市场价格-->
<!--    shop_price	decimal(10, 2)	商品价格-->
<!--    stock	int	库存-->
<!--    is_on_sale	int(1)	是否在售(1在售 0下架)-->
<!--    status	inter(1)	状态(1正常 0回收站)-->
<!--    sort	int()	排序-->
<!--    create_time	int()	添加时间-->
<!--    view_times	int()	浏览次数-->
</div>

</html>
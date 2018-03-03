<?php
/**
 * @var $this \yii\web\View;
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'logo')->hiddenInput();
//=======================webUploader  ======================
//==========引入CSS和js==========
$this->registerCssFile('@web/webuploader-0.1.5/webuploader.css');
$this->registerJsFile('@web/webuploader-0.1.5/webuploader.js',[
    //当前js文件依赖于jQuery（在jQuery后面加载）
    'depends'=>\yii\web\JqueryAsset::className()
]);
//HTML
echo <<<HTML
    <!--dom结构部分-->
    <div id="uploader-demo">
    <!--用来存放item-->
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">选择图片</div>
</div>
HTML;

$logo_upload_url = \yii\helpers\Url::to(['goods/logo-upload']);
//js代码
$this->registerJs(
    <<<JS
// 初始化Web Uploader
var uploader = WebUploader.create({

    // 选完文件后，是否自动上传。
    auto: true,

    // swf文件路径
    swf: '/webuploader-0.1.5/Uploader.swf',

    // 文件接收服务端。
    server: '{$logo_upload_url}',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#filePicker',

    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,png',
        //解决某些浏览器选择文件时很慢的问题
        mimeTypes: 'image/gif,image/jpeg,image/jpg,image/png'
    }
});
//图片上传成功
uploader.on( 'uploadSuccess', function( file,response ) {
    var imgUrl = response.url;
    console.log(imgUrl);
    //将上传成功的文件的路径赋值给logo字段
    $("#goods-logo").val(imgUrl);
    //图片回显
    $("#logo_view").attr('src',imgUrl);
    //$( '#'+file.id ).addClass('upload-state-done');
});
JS
);
echo '<img id="logo_view" />';
//==========webUploader============

echo $form->field($model,'goods_category_id')->hiddenInput();
//==========stree=========
//引入js,css文件
$this->registerCssFile('@web/ztree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/ztree/js/jquery.ztree.core.js',[
    'depends'=>\yii\web\JqueryAsset::className()
]);
//js代码
$this->registerJs(
    <<<JS
var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",//排序
                    rootPId: 0
                }
            },
            callback:{
                //节点被点击回调函数
                onClick:function(event, treeId, treeNode) {
                   // alert(treeNode.tId + ", " + treeNode.name);//会弹出数据
                   // console.log(treeNode);//打印数据
                   //将被点击节点的id写入到goods_category_id的值
                   $("#goods-goods_category_id").val(treeNode.id);
                }
            }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$nodes};//将数值转换成json数据存储格式
            zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            zTreeObj.expandAll(true);//展开所有节点
            //回显选中的节点
            zTreeObj.selectNode(zTreeObj.getNodeByParam("id", "{$model->goods_category_id}", null));
        
JS
);

//css代码
echo '
    <div>
        <ul id="treeDemo" class="ztree"></ul>
    </div>
';
//==========stree=======================

echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getBrandName());
echo $form->field($model,'market_price')->textInput();
echo $form->field($model,'shop_price')->textInput();
echo $form->field($model,'stock')->textInput();
echo $form->field($model,'is_on_sale')->radioList([1=>'在售',2=>'下架']);
echo $form->field($model,'status')->radioList([1=>'正常',0=>'回收站']);
echo $form->field($model,'sort')->textInput();
echo $form->field($intro,'content')->textarea();
/*
 * name	varchar(20)	商品名称
sn	varchar(20)	货号
logo	varchar(255)	LOGO图片
goods_category_id	int	商品分类id
brand_id	int	品牌分类
market_price	decimal(10,2)	市场价格
shop_price	decimal(10, 2)	商品价格
stock	int	库存
is_on_sale	int(1)	是否在售(1在售 0下架)
status	inter(1)	状态(1正常 0回收站)
sort	int()	排序
create_time	int()	添加时间
view_times	int()	浏览次数
 * */
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\bootstrap\ActiveForm::end();
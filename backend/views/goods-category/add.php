<?php
/**
 * @var  $this \yii\web\View;
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'parent_id')->hiddenInput();//上级分类id
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
                    pIdKey: "parent_id",
                    rootPId: 0
                }
            },
            callback:{
                //节点被点击回调函数
                onClick:function(event, treeId, treeNode) {
                   // alert(treeNode.tId + ", " + treeNode.name);//会弹出数据
                   // console.log(treeNode);//打印数据
                   //将被点击节点的id写入到parent_id的值
                   $("#goodscategory-parent_id").val(treeNode.id);
                }
            }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$nodes};//将数值转换成json数据存储格式
            zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            zTreeObj.expandAll(true);//展开所有节点
            //回显选中的节点
            zTreeObj.selectNode(zTreeObj.getNodeByParam("id", "{$model->parent_id}", null));
        
JS
);

//css代码
echo '
    <div>
        <ul id="treeDemo" class="ztree"></ul>
    </div>
';
//==========stree=======================
echo $form->field($model,'intro')->textarea();
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\bootstrap\ActiveForm::end();
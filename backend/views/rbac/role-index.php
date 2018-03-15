<?php
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('@web/DataTables-1.10.15/media/css/jquery.dataTables.css');//<!-- DataTables CSS
//<!-- jQuery -->//yii2框架自动加载jQuery.js，不需要写 -->
//$this->registerJsFile('@web/DataTables-1.10.15/media/js/jquery.js');
$this->registerJsFile('@web/DataTables-1.10.15/media/js/jquery.dataTables.js',
    [
//    当前js文件依赖于jQuery（在jQuery后面加载）
        'depends'=>\yii\web\JqueryAsset::className()
    ]
);//<!-- DataTables -->

?>
<?=\yii\bootstrap\Html::a('添加角色',['rbac/add-role'],['class'=>'btn btn-primary']);?>
<table id="example" class="display">
    <thead>
        <tr>
            <th>角色名</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($roles as $role):?>
            <tr>
                <td><?=$role->name?></td>
                <td><?=$role->description?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('编辑',['rbac/edit-role','name'=>$role->name],['class'=>'btn btn-primary'])?>
                    <?=\yii\bootstrap\Html::a('删除',['rbac/del-role','name'=>$role->name],['class'=>'btn btn-danger'])?>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php

//<!--第三步：初始化Datatables-->
$this->registerJs(
    <<<JS
        
    // $(document).ready( function () {
    //     $('#table_id_example').DataTable();
    // } );

    $('#example').DataTable({
    language: {
        "sProcessing": "处理中...",
        "sLengthMenu": "显示 _MENU_ 项结果",
        "sZeroRecords": "没有匹配结果",
        "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
        "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
        "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
        "sInfoPostFix": "",
        "sSearch": "搜索:",
        "sUrl": "",
        "sEmptyTable": "表中数据为空",
        "sLoadingRecords": "载入中...",
        "sInfoThousands": ",",
        "oPaginate": {
            "sFirst": "首页",
            "sPrevious": "上页",
            "sNext": "下页",
            "sLast": "末页"
        },
        "oAria": {
            "sSortAscending": ": 以升序排列此列",
            "sSortDescending": ": 以降序排列此列"
        }
    }
});

JS
);
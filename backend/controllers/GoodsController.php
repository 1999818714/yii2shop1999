<?php

namespace backend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsIntro;
use yii\data\Pagination;
use yii\web\UploadedFile;

use Qiniu\Storage\UploadManager;
use Qiniu\Auth;

use \kucha\ueditor\UEditor;

class GoodsController extends \yii\web\Controller
{

    //Csrf,关闭它，不然webUpload要报错
    public $enableCsrfValidation = false;
    //商品列表
    public function actionIndex()
    {
        $model = new Goods();
        $query = Goods::find();
        $page = new Pagination();
        $page->totalCount = $query->where(['status'=>'1'])->count();//总条数
        $page->defaultPageSize = 3;//每页显示多少条
        //limit 0,3  --> offset:0  limit:3
        $models = $query->offset($page->offset)->where(['status'=>'1'])->limit($page->limit)->all();
        //加载视图  render('视图的名称',视图传递参数[])

        return $this->render('index',['models'=>$models,'model'=>$model,'page'=>$page]);
    }

    //搜索
    public function actionSou(){
//        $model = new Goods();
//        $query = Goods::find()->where(['like','name','']);
        //搜索包含有鸡的所有商品
         $query = Goods::find()->where(['like','name','手机']);
        //总条数
        $total = $query->count();
        //每页字数
        $pageSize = 3;
        //当前第几页
        $page = new Pagination([
            'totalCount'=>$total,
            'pageSize'=>$pageSize
        ]);
        //设置sql参数 limit 2,5  =>  limit 5 offset 2
        $models = $query->limit($page->limit)->offset($page->offset)->all();
//        var_dump($models);exit();
//        return $this->render('index',['models'=>$models,'model'=>$model,'page'=>$page]);
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }

    //商品回收站列表
    public function actionRecycler()
    {
        $model = new Goods();
        $query = Goods::find();
        $page = new Pagination();
        $page->totalCount = $query->where(['status'=>'0'])->count();//总条数
        $page->defaultPageSize = 3;//每页显示多少条
        //limit 0,3  --> offset:0  limit:3
        $models = $query->offset($page->offset)->where(['status'=>'0'])->limit($page->limit)->all();
        //加载视图  render('视图的名称',视图传递参数[])

        return $this->render('index',['models'=>$models,'model'=>$model,'page'=>$page]);
    }

    //商品添加
    public function actionAdd(){
        $model = new Goods();
        $intro = new GoodsIntro();
        $request = \Yii::$app->request;
        //在添加时自动添加一个  sn = 当前时间+000+sn的字段

        $day = date('Y-m-d');
        $goodsDay = new GoodsDayCount();
        $goodsCount = GoodsDayCount::findOne(['day'=>$day]);
        if($goodsCount == null){
            $goodsDay->day = date('Ymd',time());
            $goodsDay->count = 1;
        }else{
            $goodsCount->count = ($goodsCount->count*1)+1;
        }
//        exit();
        //是否是post值
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            $intro->load($request->post());
            $model->create_time  = time();
            $model->view_times  = 0;
            //验证数据
            if($model->validate()){
                if($intro->validate()){
                    if($goodsDay->validate()){
                            $model->sn = date('Ymd',time()).str_pad($goodsCount->count,5,'0',STR_PAD_LEFT);
                            $model->save();
                            $intro->goods_id = $model->id;
                            $intro->save();
                            if ($goodsCount == null){
                                $goodsDay->save();
                            }else{
                                $goodsCount->save();
                            }

                        //=====七牛云=======
                            $accessKey = '2_w4wwZWCT1LcPebdZ_6uxiUcdCwOfVnMrlbyLvD';
                            $secretKey = 'oF1Boa_2rqben0uVvoRQ1bAWDYGqOTYnw234cTfb';
                            //构建鉴权对象
                            $auth = new Auth($accessKey, $secretKey);
                            //要转码的文件所在的空间
                            $bucket = 'php1016';
                            //生成上传 Token
                            $token = $auth->uploadToken($bucket);
                            //要上传文件的本地路径
                            $filePath = \Yii::getAlias('@webroot').$model->logo;
                            //上传到七牛后保存的文件名
                            $key = $model->logo;
                            //初始化 ploadManager对象并进行文件的上传。
                            $uploadMgr = new UploadManager();
                            //调用UploadManager的putFile方法进行文件的上传。
                            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
                            echo "\n===> putFile result: \n";
                            if ($err !== null) {
                                //上传有错误
                                var_dump($err);
                            } else {
                                //上传成功
                                echo '上传成功';
                                var_dump($ret);
                            }
                        //======七牛云======

                        \Yii::$app->session->setFlash('success','添加成功');
                        return $this->redirect(['goods/index']);
                        }
                    }
                }
            }else{
                //打印错误
                var_dump($model->getErrors());
        }
        $nodes = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        $nodes[] = ['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        return $this->render('add',['model'=>$model,'intro'=>$intro,'nodes'=>json_encode($nodes)]);//将数值转换成json数据存储格式
    }

    //商品修改
    public function actionEdit($id){
        $model = Goods::findOne(['id'=>$id]);
        $intro = GoodsIntro::findOne(['goods_id'=>$id]);
        $request = \Yii::$app->request;
        //是否是post值
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            $intro->load($request->post());
            //验证数据
            if($model->validate()){
                if($intro->validate()) {
                    $model->save();
                    $intro->save();
                    //=====七牛云=======
                    $accessKey = '2_w4wwZWCT1LcPebdZ_6uxiUcdCwOfVnMrlbyLvD';
                    $secretKey = 'oF1Boa_2rqben0uVvoRQ1bAWDYGqOTYnw234cTfb';
                    //构建鉴权对象
                    $auth = new Auth($accessKey, $secretKey);
                    //要转码的文件所在的空间
                    $bucket = 'php1016';
                    //生成上传 Token
                    $token = $auth->uploadToken($bucket);
                    //要上传文件的本地路径
                    $filePath = \Yii::getAlias('@webroot').$model->logo;
                    //上传到七牛后保存的文件名
                    $key = $model->logo;
                    //初始化 ploadManager对象并进行文件的上传。
                    $uploadMgr = new UploadManager();
                    //调用UploadManager的putFile方法进行文件的上传。
                    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
                    echo "\n===> putFile result: \n";
                    if ($err !== null) {
                        //上传有错误
                        var_dump($err);
                    } else {
                        //上传成功
                        echo '上传成功';
                        var_dump($ret);
                    }
                    //======七牛云======
                    \Yii::$app->session->setFlash('success', '修改成功');
                    return $this->redirect(['goods/index']);
                }
            }else{
                //打印错误
                var_dump($model->getErrors());
            }
        }
        $nodes = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        $nodes[] = ['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        return $this->render('add',['model'=>$model,'intro'=>$intro,'nodes'=>json_encode($nodes)]);//将数值转换成json数据存储格式
    }

    //删除（放入回收站）
    public function actionDel($id){
        $model = Goods::findOne(['id'=>$id]);
        $model->status = 0;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['goods/index']);
    }
    //恢复
    public function actionNoDel($id){
        $model = Goods::findOne(['id'=>$id]);
        $model->status = 1;
        $model->save();
        \Yii::$app->session->setFlash('success','恢复成功');
        return $this->redirect(['goods/recycler']);
    }

    //查看
    public function actionLook($id){
        $model = Goods::findOne(['id'=>$id]);
        $intro = GoodsIntro::findOne(['goods_id'=>$id]);
//        var_dump($intro);exit;
        $model->view_times = +1;
        $model->save();
        return $this->render('look',['model'=>$model,'intro'=>$intro]);
    }




    //处理webUploader上传文件
    public function actionLogoUpload(){
        //var_dump($_FILES);exit;
        //实例化上传文件类
        $uploadedFile = UploadedFile::getInstanceByName('file');
        //保存文件
        $fileName = '/upload/'.uniqid().'.'.$uploadedFile->extension;
        $result = $uploadedFile->saveAs(\Yii::getAlias('@webroot').$fileName);
        if($result){
            //文件保存成功
            return json_encode([
                'url'=>$fileName
            ]);
        }
    }

    //测试百度编译器ueditor
    public function actionUeditor(){
        return $this->renderPartial('ueditor');
    }

    //百度编译器用的
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
//                'config' => [
//                    "imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
//                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
//                    "imageRoot" => \Yii::getAlias("@webroot"),
//                ],
            ]
        ];
    }

}

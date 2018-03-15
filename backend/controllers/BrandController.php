<?php

namespace backend\controllers;

use backend\filters\RbacFilters;
use backend\models\Brand;
use Qiniu\Storage\UploadManager;
use yii\data\Pagination;
use yii\web\UploadedFile;

use Qiniu\Auth;
use Qiniu\Processing\PersistentFop;

class BrandController extends \yii\web\Controller
{
    //Csrf
    public $enableCsrfValidation = false;
    //品牌列表
    public function actionIndex()
    {
        $query = Brand::find();
        $page = new Pagination();
        $page->totalCount = $query->count();//总条数
        $page->defaultPageSize = 3;//每页显示多少条
        //limit 0,3  --> offset:0  limit:3
        $models = $query->offset($page->offset)->limit($page->limit)->all();

        //加载视图  render('视图的名称',视图传递参数[])
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }

    //添加品牌（图片上传使用WebUploader插件（AJAX上传）,上传成功后回显图片）
    public function actionAdd(){
        $model = new Brand();
        //实例化Request组件
        $request = \Yii::$app->request;
        //判断接受的是否是post值
        if($request->isPost){
            //加载表单提交的数据，如果属性没有验证规则，不会加载
            $model->load($request->post());
            $model->is_deleted=0;
            //在验证之前需要实例化上传组件
//            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
//            var_dump($model->imgFile);exit;
            if($model->validate()){
//                //判断是否有文件上传
//                if($model->imgFile){
//                    //保存上传文件
//                    $file = '/upload/'.uniqid().'.'.$model->imgFile->extension;
//
//                    if($model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0)){
//                        $model->logo = $file;
//                    }
//                }
                //验证通过
                //保存到数据表
                $model->save();
                //设置提示信息
                \Yii::$app->session->setFlash('success','品牌添加');
                //跳转到首页
                return $this->redirect(['brand/index']);
            }else{
                //打印错误信息
                var_dump($model->getErrors());EXIT;
            }
        }
            //调用页面
        return $this->render('add',['model'=>$model]);

    }

//修改品牌（）
    public function actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','品牌修改');
                return $this->redirect(['brand/index']);
            }else{
                //打印错误信息
                var_dump($model->getErrors());EXIT;
            }
        }
        //调用页面
        return $this->render('add',['model'=>$model]);

    }

    //逻辑删除图书(把is_deleted)
    public function actionDel($id){
        $model = Brand::findOne(['id'=>$id]);
//        var_dump($model);exit;
            $model->is_deleted=1;
                $model->save();
                //跳转到首页
                return $this->redirect(['brand/index']);
    }

    //处理webUploader上传文件
    public function actionLogoUpload(){
//var_dump($_FILES);
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

    //测试七牛云上传图片
    public function actionTest(){

        $accessKey = '2_w4wwZWCT1LcPebdZ_6uxiUcdCwOfVnMrlbyLvD';
        $secretKey = 'oF1Boa_2rqben0uVvoRQ1bAWDYGqOTYnw234cTfb';
        //构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        //要转码的文件所在的空间
        $bucket = 'php1016';
        //生成上传 Token
        $token = $auth->uploadToken($bucket);
        //要上传文件的本地路径
        $filePath = \Yii::getAlias('@webroot').'/upload/1.jpg';
        //上传到七牛后保存的文件名
        $key = '/upload/1.jpg';
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
    }

    //过滤器
    public function behaviors(){
        return [
            'rbac'=>[
                'class'=>RbacFilters::class,
                //默认情况对所有操作生效
                //排除不需要授权的操作
                'except'=>['logo-upload']
            ]
        ];
    }


}

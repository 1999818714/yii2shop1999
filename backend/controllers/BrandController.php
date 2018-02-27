<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    //品牌列表
    public function actionIndex()
    {
        $models = Brand::find()->all();
        return $this->render('index',['models'=>$models]);
    }

    //添加品牌
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
            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
//            var_dump($model->imgFile);exit;
            if($model->validate()){
                //判断是否有文件上传
                if($model->imgFile){
                    //保存上传文件
                    $file = '/upload/'.uniqid().'.'.$model->imgFile->extension;

                    if($model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0)){
                        $model->logo = $file;
                    }
                }
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

//修改品牌
    public function actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            //在验证之前需要实例化上传组件
            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                //判断是否有文件上传
                if($model->imgFile){
                    //保存上传文件
                    $file = '/upload/'.uniqid().'.'.$model->imgFile->extension;

                    if($model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0)){
                        $model->logo = $file;
                    }
                }
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

    //删除图书
    public function actionDel($id){
        $model = Brand::findOne(['id'=>$id]);
        $model->delete();
        //设置提示信息
        \Yii::$app->session->setFlash('success','删除成功');
        //跳转到首页
        return $this->redirect(['brand/index']);
    }

}

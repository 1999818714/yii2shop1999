<?php

namespace backend\controllers;


use backend\filters\RbacFilters;
use backend\models\ArticleCategory;

class ArticleCategoryController extends \yii\web\Controller
{
    //文章分类管理页面
    public function actionIndex()
    {
        $models = ArticleCategory::find()->all();
//        var_dump($models);exit;
        return $this->render('index',['models'=>$models]);
    }

    //文章分类管理添加
    public function actionAdd(){
        $model = new ArticleCategory();
        //实例化Request组件
        $request = \Yii::$app->request;
        //判断接受的是否是post值
        if($request->isPost){
            //加载表单提交的数据，如果属性没有验证规则，不会加载
            $model->load($request->post());
            $model->is_deleted=0;
            if($model->validate()){
                $model->save();
                //设置提示信息
                \Yii::$app->session->setFlash('success','文章分类管理添加');
                //跳转到首页
                return $this->redirect(['article-category/index']);
            }else{
                //打印错误信息
                var_dump($model->getErrors());EXIT;
            }
        }
        //调用页面
        return $this->render('add',['model'=>$model]);
    }

    //文章分类管理修改
    public function actionEdit($id){
        $model = ArticleCategory::findOne(['id'=>$id]);
        //实例化Request组件
        $request = \Yii::$app->request;
        //判断接受的是否是post值
        if($request->isPost){
            //加载表单提交的数据，如果属性没有验证规则，不会加载
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                //设置提示信息
                \Yii::$app->session->setFlash('success','文章分类管理修改');
                //跳转到首页
                return $this->redirect(['article-category/index']);
            }else{
                //打印错误信息
                var_dump($model->getErrors());EXIT;
            }
        }
        //调用页面
        return $this->render('add',['model'=>$model]);
    }

    //删除
    public function actionDel($id){
        $model = ArticleCategory::findOne(['id'=>$id]);
        $model->delete();
        //设置提示信息
        \Yii::$app->session->setFlash('success','删除成功');
        //跳转到首页
        return $this->redirect(['article-category/index']);
    }

    //过滤器
    public function behaviors(){
        return [
            'class' => RbacFilters::class
        ];
    }

}

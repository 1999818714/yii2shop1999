<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleDetail;

class ArticleController extends \yii\web\Controller
{
    //文章列表
    public function actionIndex()
    {
        $models = Article::find()->all();
        return $this->render('index',['models'=>$models]);
    }

    //文章添加
    public function actionAdd(){
        $article = new Article();
        $article_detail  = new  ArticleDetail();
        //实例化Request组件
        $request = \Yii::$app->request;
        //判断接受的是否是post值
        if($request->isPost){
            //加载表单提交的数据，如果属性没有验证规则，不会加载
            $article->load($request->post());
            $article_detail->load($request->post());
            $article->is_deleted=0;
            $article->create_time = time();
//            var_dump($article_detail);exit;
            if($article->validate()){
                if($article_detail->validate()){
                    $article->save();
                    $article_detail->article_id = $article->id;
                    $article_detail->save();
                    //设置提示信息
                    \Yii::$app->session->setFlash('success','文章添加');
                    //跳转到首页
                    return $this->redirect(['article/index']);
                }
            }else{
                //打印错误信息
                var_dump($article->getErrors());EXIT;
            }
        }
        //调用页面
        return $this->render('add',['model'=>$article,'article_detail'=>$article_detail]);
    }

//文章修改
    public function actionEdit($id){
        $article = Article::findOne(['id'=>$id]);
        $article_detail  = ArticleDetail::findOne(['article_id'=>$id]);
        //实例化Request组件
        $request = \Yii::$app->request;
        //判断接受的是否是post值
        if($request->isPost){
            //加载表单提交的数据，如果属性没有验证规则，不会加载
            $article->load($request->post());
            $article_detail->load($request->post());
            $article->is_deleted=0;
            $article->create_time = time();
//            var_dump($article_detail);exit;
            if($article->validate()){
                if($article_detail->validate()){
                    $article->save();
                    $article_detail->article_id = $article->id;
                    $article_detail->save();
                    //设置提示信息
                    \Yii::$app->session->setFlash('success','文章修改');
                    //跳转到首页
                    return $this->redirect(['article/index']);
                }
            }else{
                //打印错误信息
                var_dump($article->getErrors());EXIT;
            }
        }
        //调用页面
        return $this->render('add',['model'=>$article,'article_detail'=>$article_detail]);
    }

    //逻辑删除
    public function actionDel($id){
        $model = Article::findOne(['id'=>$id]);
        $model->is_deleted=1;
        $model->save();
        //设置提示信息
        \Yii::$app->session->setFlash('success','逻辑删除成功');
        //跳转到首页
        return $this->redirect(['article/index']);
    }

}

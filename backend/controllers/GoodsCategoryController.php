<?php

namespace backend\controllers;

use backend\filters\RbacFilters;
use backend\models\GoodsCategory;

class GoodsCategoryController extends \yii\web\Controller
{
    //商品分类列表
    public function actionIndex()
    {
        $models = GoodsCategory::find()->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC,'id'=>SORT_ASC])->all();
        return $this->render('index',['models'=>$models]);
    }
    //商品分类添加
    public function actionAdd(){
        $model = new GoodsCategory();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id){
                    //子节点
                    $countries = GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($countries);
                }else{
                    //根节点
                    $model->makeRoot();
                }

//                $model->save();
                \Yii::$app->session->setFlash('success','商品添加');
                return $this->redirect(['goods-category/index']);
            }
        }
        $nodes = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        $nodes[] = ['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        return $this->render('add',['model'=>$model,'nodes'=>json_encode($nodes)]);//将数值转换成json数据存储格式
    }

    //商品分类修改
    public function actionEdit($id){
        $model = GoodsCategory::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id){
                    //子节点
                    $countries = GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($countries);
                }else{
                    //根节点
                    //解决修改根节点报错的  ==0可以写可以不写，这里parent_id=0
                    if($model->getOldAttribute('parent_id') == 0){
                        //旧的parent_id改为新的parent_id会报错
                    }else{
                        $model->makeRoot();
                    }
                }

//                $model->save();
                \Yii::$app->session->setFlash('success','商品修改');
                return $this->redirect(['goods-category/index']);
            }
        }
        $nodes = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        $nodes[] = ['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        return $this->render('add',['model'=>$model,'nodes'=>json_encode($nodes)]);//将数值转换成json数据存储格式
    }

    //删除
    public function actionDel($id){
        $model = GoodsCategory::findOne(['id'=>$id]);
        //删除不了顶级分类，调试
        if($model->parent_id==0){
            $model->deleteWithChildren();
        }else{
            $model->delete();
        }
        //设置提示信息
        \Yii::$app->session->setFlash('success','删除成功');
        //跳转到首页
        return $this->redirect(['goods-category/index']);
    }

    //测试
    public function actionTest(){
        //添加根节点
        /*$countries = new GoodsCategory();
        $countries->name = '家用电器';
        $countries->parent_id = 0;
        $countries->makeRoot();*/

        //添加子节点
        /*$countries = GoodsCategory::findOne(['id'=>1]);
        $russia = new GoodsCategory();
        $russia->name = '空调';
        //子节点id必须等于根节点的parent_id
        $russia->parent_id = $countries->id;
        $russia->prependTo($countries);*/
//var_dump($russia->getErrors());
        echo '操作成功';
    }

    //ztree测试
    public function actionZtree(){
        //$this->layout = false;//不加载布局文件
        $nodes = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
//        var_dump($nodes);exit;
        return $this->renderPartial('ztree',['nodes'=>$nodes]);
    }

    //过滤器
    public function behaviors(){
        return [
            'class' => RbacFilters::class
        ];
    }


}

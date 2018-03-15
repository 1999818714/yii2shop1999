<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/8/008
 * Time: 14:31
 */

namespace backend\controllers;


use backend\filters\RbacFilters;
use backend\models\Menu;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class MenuController extends Controller
{

    //菜单列表
    public function actionIndex(){
//        $models = Menu::find()->all();
//        foreach (){
//
//        }
        $models = Menu::find()->orderBy('id')->orderBy('parent_id')->all();//显示1,2,3...级菜单
        return $this->render('index',['models'=>$models]);
    }

    //添加菜单
    public function actionAdd(){
        $model = new Menu();
        $request = \Yii::$app->request;

//        $menus = ArrayHelper::map(Menu::findAll(['parent_id'=>0]),'id','name');
//        $menu = ArrayHelper::merge([''=>'=请选择上级菜单=','0'=>'顶级分类'],$menus);

        $cate = ArrayHelper::map(Menu::find()->asArray()->all(),'id','name');
        //获取分类信息
        $menu = ArrayHelper::merge(['0'=>'顶级分类'],$cate);

        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
//                var_dump($model);exit();
                $model->save();
                \Yii::$app->session->setFlash('success','添加菜单成功');
                return $this->redirect(['menu/index']);
            }
        }

        return $this->render('add',['model'=>$model,'menu'=>$menu]);
    }

    //添加菜单
    public function actionEdit($id){
        $model = Menu::findOne(['id'=>$id]);
        $request = \Yii::$app->request;

        $menus = ArrayHelper::map(Menu::findAll(['parent_id'=>0]),'name','name');
        $menu = ArrayHelper::merge([' '=>'=请选择上级菜单=','0'=>'顶级分类'],$menus);

        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加菜单成功');
                return $this->redirect(['menu/index']);
            }
        }

        return $this->render('add',['model'=>$model,'menu'=>$menu]);
    }


    //过滤器
    public function behaviors(){
        return [
            'class' => RbacFilters::class
        ];
    }

}
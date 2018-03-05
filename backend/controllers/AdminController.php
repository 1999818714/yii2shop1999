<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/4/004
 * Time: 10:56
 */

namespace backend\controllers;


use backend\models\Admin;
use backend\models\LoginForm;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
{
    //管理员列表
    public function actionIndex(){
        $models = Admin::find()->all();
        return $this->render('index',['models'=>$models]);
    }

    //管理员添加
    public function actionAdd()
    {
        $model = new Admin();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->created_at = time();//注册时间
                $model->auth_key = \Yii::$app->security->generateRandomString();//随机数
                $model->status = 1;
                $model->password = \Yii::$app->security->generatePasswordHash($model->password);//加密
                $model->save();
                \Yii::$app->session->getFlash('success','添加成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //管理员修改
    public function actionEdit($id)
    {
        $model = Admin::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->updated_at = time();//修改时间
                //判断密码是否被修改
                if($model->getOldAttribute('password') != $model->password){
                    $model->password = \Yii::$app->security->generatePasswordHash($model->password);
                }
                $model->save();
                \Yii::$app->session->getFlash('success','修改成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //管理员修改密码
    public function actionPass($id)
    {
        $model = Admin::findOne(['id'=>$id]);
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //判断密码是否被修改
                if($model->getOldAttribute('password') != $model->password){
                    $model->password = \Yii::$app->security->generatePasswordHash($model->password);
                }
                $model->save();
                \Yii::$app->session->getFlash('success','密码修改成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('pass',['model'=>$model]);
    }

    //登录
    public function actionLogin(){
        //判断是不是游客
//        var_dump(\Yii::$app->user->isGuest);exit;
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->login()){
                    //登录成功
                    $admins = Admin::findOne(['username'=>$model->username]);
                    $admins->last_login_time = time();
                    $admins->last_login_ip = $_SERVER["REMOTE_ADDR"];
                    $admins->save();
                    \Yii::$app->session->setFlash('success','登录成功');
                    return $this->redirect(['admin/index']);
                }
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    //注销
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','注销成功!');
        return $this->redirect(['admin/login']);
    }

//    //只给想要给的用户访问
    public function actionOne(){
//        if(\Yii::$app->user->identity->username == '刘鹏'){
           echo '你可以看';
//        }else{
//            echo '你不可以看';
//        }
    }

    //配置过滤器
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],//指定那些操作需要使用该过滤器. 缺省only,表示所有操作
                'rules' => [
                    [
                        'actions' => [],//操作//未写的都禁止
                        'allow' => true,//是否允许
                        'roles' => ['@'],//角色 @已认证(登录)用户
                    ],
                    [
                        'actions'=>['login','index'],
                        'allow'=>true,
                        'roles'=>['?'],//? 未认证(未登录)用户
                    ],
                    [
                        'actions'=>['one'],
                        'allow'=>true,
                        'matchCallback'=>function(){
//                            return true;//允许访问
//                            return false;//不允许访问
                            //只有刘鹏可以访问
                            return  \Yii::$app->user->id && \Yii::$app->user->identity->username == '刘鹏';
                        }
                    ],
                ],
            ],
        ];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/4/004
 * Time: 10:56
 */

namespace backend\controllers;


use backend\filters\RbacFilters;
use backend\models\Admin;
use backend\models\LoginForm;
use backend\models\PassForm;
use backend\models\RepForm;
use yii\bootstrap\ActiveForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

class AdminController extends Controller
{
    //管理员列表
    public function actionIndex(){
        $query = Admin::find()->where(['status'=>'1']);
        $page = new Pagination();
        $page->totalCount = $query->count();//总条数
        $page->defaultPageSize = 3;//每页显示多少条
        //limit 0,3  --> offset:0  limit:3
        $models = $query->offset($page->offset)->where(['status'=>'1'])->limit($page->limit)->all();

        //加载视图  render('视图的名称',视图传递参数[])
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }
    //管理员被删除列表
    public function actionRecycler()
    {
        $query = Admin::find()->where(['status'=>'0']);
        $page = new Pagination();
        $page->totalCount = $query->count();//总条数
        $page->defaultPageSize = 3;//每页显示多少条
        //limit 0,3  --> offset:0  limit:3
        $models = $query->offset($page->offset)->limit($page->limit)->all();
        //加载视图  render('视图的名称',视图传递参数[])

        return $this->render('index',['models'=>$models,'page'=>$page]);
    }

    //删除（放入回收站）
    public function actionDel($id){
        $model = Admin::findOne(['id'=>$id]);
        $model->status = 0;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['admin/index']);
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
                //用户添加角色
                $authManager = \Yii::$app->authManager;
                if(is_array($model->role)){
                    foreach ($model->role as $role){
                        $authManager->assign($authManager->getRole($role),$model->id);
                    }
                }

                    \Yii::$app->session->getFlash('success','添加用户成功');
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


        $authManager = \Yii::$app->authManager;
        $model->role = array_keys($authManager->getRolesByUser($id));
        if($model->role == null){
            throw new HttpException(404,'角色不存在');
        }


        //坑:这里指定的场景,验证规则中必须存在该场景
        // $model->scenario = User::SCENARIO_EDIT;
        //判断该用户是否存在
        if(!$model ){
            throw new HttpException(404,'该用户不存在或已被删除');
        }
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->updated_at = time();//修改时间

                $model->save();
                //用户修改角色
                //清除以前的角色
                $authManager->revokeAll($model->id);
                if(is_array($model->role)){
                    foreach ($model->role as $role){
                        $authManager->assign($authManager->getRole($role),$model->id);
                    }
                }

                \Yii::$app->session->getFlash('success','修改成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //管理员修改密码
    public function actionPass()
    {
        $admin = \Yii::$app->user->identity;//Admin::findOne(['id'=>1]);
        $model = new PassForm();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $admin->password = \Yii::$app->security->generatePasswordHash($model->newPassword);
                $admin->save();
                \Yii::$app->user->logout();
                \Yii::$app->session->getFlash('success','密码修改成功,请用新密码重新登录');
                return $this->redirect(['admin/login']);
            }
        }
        $model->username = $admin->username;
        return $this->render('pass',['model'=>$model]);
    }

    //重置密码
    public function actionRep($id){
        $admin = Admin::findOne(['id'=>$id]);
        $model = new RepForm();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $admin->password = \Yii::$app->security->generatePasswordHash($model->password);
                $admin->save();
                \Yii::$app->session->getFlash('success','重置密码成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('rep',['model'=>$model]);
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
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['login'],//指定那些操作需要使用该过滤器. 缺省only,表示所有操作
//                'rules' => [
//                    [
//                        'actions' => [],//操作//未写的都禁止
//                        'allow' => false,//是否允许
//                        'roles' => ['@'],//角色 @已认证(登录)用户
//                    ],
//                    [
//                        'actions'=>['login','index'],
//                        'allow'=>true,
//                        'roles'=>['?'],//? 未认证(未登录)用户
//                    ],
//                    [
//                        'actions'=>['one'],
//                        'allow'=>true,
//                        'matchCallback'=>function(){
////                            return true;//允许访问
////                            return false;//不允许访问
//                            //只有刘鹏可以访问
//                            return  \Yii::$app->user->id && \Yii::$app->user->identity->username == '刘鹏';
//                        }
//                    ],
//                ],
//            ],
//        ];
//    }

    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilters::class,
                //默认情况对所有操作生效
                //排除不需要授权的操作
                'except'=>['login','logout','pass','index']
            ]
        ];
    }



}
<?php

namespace backend\controllers;

use backend\filters\RbacFilters;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\web\HttpException;

class RbacController extends \yii\web\Controller
{

//RBAC所有操作都是通过authManager组件的方法来进行的(不要直接操作数据表,也没有活动记录)
    public function actionTest(){
        $authManager = \Yii::$app->authManager;
        //用户 admin zhangsan
        //权限 添加品牌(brand/add)   品牌列表(brand/index)
        //添加权限
        //创建权限
//        $per = $authManager->createPermission('brand/add');
//        $per->description = '添加品牌';
//        //保存到数据库
//        $authManager->add($per);
//
//        $per2 = $authManager->createPermission('brand/index');
//        $per2->description = '品牌列表';
//        //保存到数据库
//        $authManager->add($per2);

        //创建角色
        //角色 超级管理员  普通员工
        //添加角色
        //1.创建角色
//        $role = $authManager->createRole('超级管理员');
//        //2.保存到数据库
//        $authManager->add($role);
//
//        $role2 = $authManager->createRole('普通会员');
//        $authManager->add($role2);

        //给角色关联权限
        // 超级管理员-->添加品牌,品牌列表    普通员工-->品牌列表
        //角色(parent),权限(child)
//        $role = $authManager->getRole('超级管理员');//获得角色
//        $per = $authManager->getPermission('brand/add');//获取权限
//        $per2 = $authManager->getPermission('brand/index');//获取权限
//        $authManager->addChild($role,$per);
//        $authManager->addChild($role,$per2);

//        $role = $authManager->getRole('普通会员');
//        $per = $authManager->getPermission('brand/index');
//        $authManager->addChild($role,$per);

        //给用户指派角色  1刘鹏-->超级管理员  2小二->普通员工
//        $role1 = $authManager->getRole('超级管理员');
//        $role2 = $authManager->getRole('普通会员');
//        $authManager->assign($role1,1);
//        $authManager->assign($role2,2);

        //测试当前用户的权限
        $result = \Yii::$app->user->can('brand/add');
        //小二能否执行brand/add
        var_dump($result);

        echo '操作完成';
    }


    //权限列表
    public function actionPermissionIndex()
    {
        $authManager = \Yii::$app->authManager;
        //获取所有权限
        $permissions = $authManager->getPermissions();
        return $this->render('permission-index',['permissions'=>$permissions]);
    }

    //添加权限
    public function actionAddPermission(){
        $model = new PermissionForm();
        $model->scenario = PermissionForm::SCENARIO_ADD;
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $authManager = \Yii::$app->authManager;
                //1.创建权限 使用路由作为权限名称,方便后面的权限检测
                $permission = $authManager->createPermission($model->name);
                $permission->description = $model->description;
                //2.保存到数据表
                if($authManager->add($permission)){
                    \Yii::$app->session->setFlash('success','添加权限成功');
                    return $this->redirect(['rbac/permission-index']);
                }
            }
        }
        return $this->render('add-permission',['model'=>$model]);
    }

    //修改权限
    public function actionEditPermission($name){
        $authManager = \Yii::$app->authManager;
        $permission = $authManager->getPermission($name);
        if($permission == null){
            throw new HttpException(404,'权限不存在');
        }
        $model = new PermissionForm();
        $model->scenario = PermissionForm::SCENARIO_EDIT;
        $model->name = $permission->name;//主要是为了回显name值
        $model->description = $permission->description;//主要是为了回显description值

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //1.创建权限 使用路由作为权限名称,方便后面的权限检测
                $permission->name = $model->name;//页面传过来的值赋值
                $permission->description = $model->description;
                //2.修改到数据表
                $authManager->update($name,$permission);

                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['rbac/permission-index']);
            }
        }
        return $this->render('add-permission',['model'=>$model]);
    }

    //权限删除
    public function actionDelPermission($name){
        $authManager = \Yii::$app->authManager;
        $permission = $authManager->getPermission($name);
        $authManager->remove($permission);
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['rbac/permission-index']);

    }


    //角色列表
    public function actionRoleIndex()
    {
        $authManager = \Yii::$app->authManager;
        //获取所有角色
        $roles = $authManager->getRoles();
        return $this->render('role-index',['roles'=>$roles]);
    }

    //添加角色
    public function actionAddRole(){
        $model = new RoleForm();
        $model->scenario = RoleForm::SCENARIO_ADD;
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $authManager = \Yii::$app->authManager;
                //1.创建角色
                $role = $authManager->createRole($model->name);
                $role->description = $model->description;
                //2.保存到数据表
                if($authManager->add($role)){
                    //给角色关联权限
                    foreach($model->permissions as $permission){
                        $permission = $authManager->getPermission($permission);
                        $authManager->addChild($role,$permission);
                    }
                    \Yii::$app->session->setFlash('success','添加角色成功');
                    return $this->redirect(['rbac/role-index']);
                }
            }
        }
        return $this->render('add-role',['model'=>$model]);
    }

    //修改角色
    public function actionEditRole($name){
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        if($role == null){
            throw new HttpException(404,'角色不存在');
        }
        $model = new RoleForm();
        $model->scenario = RoleForm::SCENARIO_EDIT;
        //回显值
        $model->name = $role->name;
        $model->description = $role->description;
        //获得角色的所有权限//array_keys() 函数返回包含数组中所有键名的一个新数组
        $permissions = $authManager->getPermissionsByRole($role->name);
        $model->permissions = array_keys($permissions);

        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //1.创建角色
                $role->name = $model->name;
                $role->description = $model->description;
                //2.保存到数据表
                $authManager->update($name,$role);
                //清除已关联的权限
                $authManager->removeChildren($role);
                //给角色关联权限
                if(is_array($model->permissions)){
                    foreach($model->permissions as $permission){
                        $permission = $authManager->getPermission($permission);
                        $authManager->addChild($role,$permission);
                    }
                }
                    \Yii::$app->session->setFlash('success','修改角色成功');
                    return $this->redirect(['rbac/role-index']);

            }
        }
        return $this->render('add-role',['model'=>$model]);
    }

    //角色删除
    public function actionDelRole($name){
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        $authManager->remove($role);
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['rbac/role-index']);

    }


    //过滤器
//    public function behaviors(){
//        return [
//            'class' => RbacFilters::class
//        ];
//    }

}

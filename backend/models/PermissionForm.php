<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/7/007
 * Time: 16:26
 */

namespace backend\models;


use yii\base\Model;

class PermissionForm extends Model
{
    public $name;
    public $description;

    const SCENARIO_ADD =  'add';
    const SCENARIO_EDIT =  'edit';

    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            //权限名不能重复
            ['name','validateName','on'=>self::SCENARIO_ADD],
            ['name','ChangName','on'=>self::SCENARIO_EDIT],
            ];
    }

    public function attributeLabels(){
        return [
            'name'=>'名称(路由)',
            'description'=>'描述',
        ];

    }

    //自定义验证方法,只处理错误情况
    public function validateName(){
        $authManager = \Yii::$app->authManager;
        //获取权限
        if($authManager->getPermission($this->name)){
            //权限已存在
            $this->addError('name','权限已存在');
        }
    }

    public function ChangName(){
        //如果修改了name,需要验证name是否存在
        if(\Yii::$app->request->get('name') != $this->name){
            $this->validateName();
        }
        //旧name
        //$this->name;//修改后的name
        //如果没有修改name,则不验证name
    }



}
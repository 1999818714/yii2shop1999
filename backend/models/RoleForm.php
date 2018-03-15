<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/7/007
 * Time: 16:26
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    public $name;//角色名
    public $description;//描述
    public $permissions = [];//权限

    const SCENARIO_ADD =  'add';
    const SCENARIO_EDIT =  'edit';

    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            //角色名不能重复
            ['name','validateName','on'=>self::SCENARIO_ADD],
            ['name','ChangName','on'=>self::SCENARIO_EDIT],
            ['permissions','safe'],
            ];
    }

    public function attributeLabels(){
        return [
            'name'=>'角色名',
            'description'=>'描述',
            'permissions'=>'权限',
        ];

    }

    //自定义验证方法,只处理错误情况
    public function validateName(){
        $authManager = \Yii::$app->authManager;
        //获取角色
        if($authManager->getRole($this->name)){
            //角色已存在
            $this->addError('name','角色已存在');
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


    //获取所有权限
    public static function getPermissionOptions(){
        $permissions = \Yii::$app->authManager->getPermissions();
        return ArrayHelper::map($permissions,'name','description');
    }

}
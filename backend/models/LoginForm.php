<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/2
 * Time: 15:46
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;//用户名
    public $password;//密码
    public $remember;

    public function rules()
    {
        return [
            [['username','password'],'required'],
            ['remember','boolean']

        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码'
        ];
    }

    /*
     * 登陆验证
     * */
    public function login(){
        if($this->validate()){
            //先根据用户名查找用户
            $admin = Admin::findOne(['username'=>$this->username]);
//            var_dump($admin->salt);exit;
            if($admin){
                //验证密码
//                var_dump(\Yii::$app->security->validatePassword($this->password,$admin->password));exit;
                if(\Yii::$app->security->validatePassword($this->password,$admin->password)){
                    //保存用户到session
//                    \Yii::$app->user->login($admin,3600*24*7);
                    \Yii::$app->user->login($admin,$this->remember?3600*24*7 :0);
                    return true;
                }else{
                    $this->addError('password','密码错误!');//添加错误信息
                }
            }else{
                //用户名不存在
                $this->addError('username','用户名不存在');
            }
        }
        return false;
    }
}
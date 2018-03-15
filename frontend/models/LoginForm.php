<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/9/009
 * Time: 18:06
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;//用户名
    public $password;//密码
    public $remember;//自动登录


    public function rules(){
        return[
            [['username','password'],'required'],
            ['remember','safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码'
        ];
    }


    //验证自动登录数据
    public function login(){
        if($this->validate()){
            //根据用户名查找用户
            $member = Member::findOne(['username'=>$this->username]);
            if($member){
                //验证密码
                if(\Yii::$app->security->validatePassword($this->password,$member->password)){
                    //添加最后登录IP和时间
                    $member->last_login_time = time();
                    $member->last_login_ip = ip2long($_SERVER['REMOTE_ADDR']) ;
                    $member->save();
                    //保存到session
//                    \Yii::$app->user->login($member,3600*24*7);
                    \Yii::$app->user->login($member,$this->remember?3600*24*7:0);
                    return true;
                }else{
                    $this->addError('password','密码不正确');//添加错误信息
                }
            }else{
                $this->addError('username','用户名不存在');
            }
        }
        return false;
    }




}
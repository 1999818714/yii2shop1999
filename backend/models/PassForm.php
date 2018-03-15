<?php
namespace backend\models;


use yii\base\Model;

class PassForm extends Model{
    public $username;//用户名
    public $oldPassword;//旧密码
    public $newPassword;//新密码
    public $rePassword;//确认密码

    public function rules()
    {
        return [
            [['oldPassword','newPassword','rePassword'],'required'],
            //新密码和确认密码一致
            ['rePassword','validateRePassword'],
            //验证旧密码
            ['oldPassword','validatePassword'],
        ];
    }

    public function validateRePassword(){
        $result = $this->rePassword == $this->newPassword;
        if($result==false){
             $this->addError('rePassword','新密码和确认密码不一致');
        }
    }
    public function validatePassword(){
        //只处理验证不通过的情况
        $result = \Yii::$app->security->validatePassword($this->oldPassword,\Yii::$app->user->identity->password);
        if($result==false){
            //添加错误信息
            $this->addError('oldPassword','旧密码不正确');
        }

    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'oldPassword'=>'旧密码',
            'newPassword'=>'新密码',
            'rePassword'=>'确认密码',
        ];
    }



}
<?php
namespace backend\models;


use yii\base\Model;

class RepForm extends Model{
    public $password;//旧密码

    public function rules()
    {
        return [
            [['password'],'required'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'password'=>'密码',
        ];
    }



}
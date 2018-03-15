<?php

namespace frontend\controllers;




use frontend\aliyun\SignatureHelper;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\web\HttpException;

class MemberController extends \yii\web\Controller
{
    //注册列表
    public function actionIndex()
    {
        $models = Member::find()->all();
        return $this->render('index',['models'=>$models]);
    }

    //验证用户名唯一
    public function actionValidateMember($username){
        //远程地址只能输出 "true" 或 "false"，不能有其他输出。
//        return "false";
        $model = Member::findOne(['username'=>$username]);
        if($model){
            return "false";
        }
        return 'true';
    }

    //用户注册
    public function actionRegister(){
        $model = new Member();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post(),'');
            if($model->validate()){
                $model->auth_key = \Yii::$app->security->generateRandomString();
                if($model->password == $model->rePassword){
                    $model->password = \Yii::$app->security->generatePasswordHash($model->rePassword);
                    $model->save();
                    \Yii::$app->session->setFlash('success','用户注册成功');
                }else{
                    var_dump('注册失败');exit;
                }
                return $this->redirect(['member/index']);

            }
        }

        return $this->render('register',['model'=>$model]);
    }

    //用户登录
    public function actionLogin(){
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if($request->isPost){

            $model->load($request->post(),'');

            if($model->validate()){
//                var_dump($model);exit;
                if($model->login()){
                 \Yii::$app->session->setFlash('success','登录成功');
                 return $this->redirect(['shop/index']);
                }else{
                    var_dump($model->getErrors());
                }
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('login',['model'=>$model]);

    }

    //退出登录
    public function actionLogout(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','退出登录成功');
        return $this->redirect(['member/login']);
    }

    //删除
    public function actionDel($id){
        $model = Member::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['member/index']);
    }

    //验证短信验证码
    public function actionValidateSms($tel,$code){
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $c = $redis->get('code_'.$tel);
        if($c == $code){
            return 'true';
        }
        return 'false';
    }

    public function actionRedis(){

    }

    //发送短信
    public function actionSms($tel){
        //保存验证码 mysql session redis
        $code = rand(100000,999999);

        $redis = new \Redis();
        $redis->connect('127.0.0.1');
//        var_dump($redis->connect('127.0.0.1'));die();
        $redis->set('code_'.$tel,$code,5*60);

        $r=\Yii::$app->sms->setTel($tel)
            ->setParams(['code'=>$code])
            ->send();
        if($r){
            return 'success';
        }
        return 'fail';
    }

    //测试短信验证
    public function actionTestSms(){
        $r = \Yii::$app->sms->setTel('17313227001')->setParams(['code'=>rand(100000,999999)])->send();
            var_dump($r);
//        $params = array ();
//
//        // *** 需用户填写部分 ***
//
//        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
//        $accessKeyId = "LTAIL5wjp1WnjiUc";
//        $accessKeySecret = "BnM8dA7p6YeBL5TnsOzPdmctM307CQ";
//
//        // fixme 必填: 短信接收号码
//        $params["PhoneNumbers"] = "17313227001";
//
//        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
//        $params["SignName"] = "刘鹏666";
//
//        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
//        $params["TemplateCode"] = "SMS_61465004";
//
//        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
//        $params['TemplateParam'] = Array (
//            "code" => rand(1000,9999),
////            "product" => "阿里通信"
//        );
//
//        // fixme 可选: 设置发送短信流水号
//        $params['OutId'] = "12345";
//
//        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
//        $params['SmsUpExtendCode'] = "1234567";
//
//
//        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
//        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
//            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
//        }
//
//        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
//        $helper = new SignatureHelper();
//
//        // 此处可能会抛出异常，注意catch
//        $content = $helper->request(
//            $accessKeyId,
//            $accessKeySecret,
//            "dysmsapi.aliyuncs.com",
//            array_merge($params, array(
//                "RegionId" => "cn-hangzhou",
//                "Action" => "SendSms",
//                "Version" => "2017-05-25",
//            ))
//        );
//
////        var_dump($content);
////        return $content;
//        if($content->Message == 'OK' && $content->Code == 'OK'){
//            echo '短信发送成功';
//        }else{
//            echo '短信发送失败';
//        }
//
    }


}

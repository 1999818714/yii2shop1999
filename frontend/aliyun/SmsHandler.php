<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/11/011
 * Time: 14:28
 */

namespace frontend\aliyun;


use yii\base\Component;

class SmsHandler extends Component
{
    public $ak;
    public $sk;
    public $sign;//签名名称
    public $template;//模板CODE
    private $_tel;
    private $_params;

    //设置手机号码
    public function setTel($tel){
        $this->_tel = $tel;
        return $this;
    }
    //设置变量值
    public function setParams($params){
        $this->_params = $params;
        return $this;
    }
    //发送短信
    public function send(){
        $params = [
            'PhoneNumbers'=>$this->_tel,
            'SignName'=>$this->sign,
            'TemplateCode'=>$this->template,
            'TemplateParam'=>$this->_params
        ];
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $this->ak,
            $this->sk,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );

        return ($content->Message == 'OK' && $content->Code == 'OK');

    }

}
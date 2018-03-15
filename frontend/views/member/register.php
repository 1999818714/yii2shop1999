<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>用户注册</title>
    <link rel="stylesheet" href="/style/base.css" type="text/css">
    <link rel="stylesheet" href="/style/global.css" type="text/css">
    <link rel="stylesheet" href="/style/header.css" type="text/css">
    <link rel="stylesheet" href="/style/login.css" type="text/css">
    <link rel="stylesheet" href="/style/footer.css" type="text/css">
</head>
<body>
<style>
    #signupForm input.error { border: 1px solid red; }
    span.error {
        /*background:url("./demo/images/unchecked.gif") no-repeat 0px 0px;*/

        padding-left: 16px;

        padding-bottom: 2px;

        font-weight: bold;

        color: #EA5200;
    }
    span.checked {
        /*background:url("./demo/images/checked.gif") no-repeat 0px 0px;*/
    }
</style>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎来到京西！
                    <?php
                    //判断是否登陆,而显视登陆或退出
                    if(Yii::$app->user->isGuest){
                        echo ' [<a href="/member/login.html">登录</a>] </li>';
                    }else{
                        echo ' [<a href="/member/logout.html">'.'退出登录 (' . Yii::$app->user->identity->username.')'.'</a>] </li>';
                    }
                    ?>
                </li>
                <li>[<a href="/member/register.html">免费注册</a>] </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
    </div>
</div>
<!-- 页面头部 end -->

<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <form id="signupForm" action="" method="post">
                <ul>
                    <li>
                        <label for="">用户名：</label>
                        <input type="text" class="txt" name="username" />
                        <p>3-20位字符，可由中文、字母、数字和下划线组成</p>
                    </li>
                    <li>
                        <label for="">密码：</label>
                        <input type="password" class="txt" id="password" name="password" />
                        <p>6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号</p>
                    </li>
                    <li>
                        <label for="">确认密码：</label>
                        <input type="password" class="txt" name="rePassword" />
                        <p> <span>请再次输入密码</p>
                    </li>
                    <li>
                        <label for="">邮箱：</label>
                        <input type="text" class="txt" name="email" />
                        <p>邮箱必须合法</p>
                    </li>
                    <li>
                        <label for="">手机号码：</label>
                        <input type="text" class="txt" value="" name="tel" id="tel" placeholder=""/>
                    </li>
                    <li>
                        <label for="">验证码：</label>
                        <input type="text" class="txt" value="" placeholder="请输入短信验证码" name="code" disabled="disabled" id="code"/> <input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>
                        <span id="get-msm"></span>
                    </li>
                    <li class="checkcode">
                        <label for="">验证码：</label>
                        <input type="text"  name="captcha" />
                        <img id="img_captcha" alt="" />
                        <span>看不清？<a href="javascript:;" id="change_captcha">换一张</a></span>
                    </li>

                    <li>
                        <label for="">&nbsp;</label>
                        <input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="" class="login_btn" />
                    </li>
                </ul>
                <!--                //这个表单必写，在form表单中自带，在HTML中需要自己写-->
                <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>

            </form>


        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/images/xin.png" alt="" /></a>
        <a href=""><img src="/images/kexin.jpg" alt="" /></a>
        <a href=""><img src="/images/police.jpg" alt="" /></a>
        <a href=""><img src="/images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->
<script src="http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js"></script>
<script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
    $().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
        $("#signupForm").validate({
            rules: {
                // firstname: "required",
                // lastname: "required",
                username: {
                    required: true,
                    minlength: 2,
                    remote:"<?=\yii\helpers\Url::to(['member/validate-member'])?>"
                },
                captcha:"validateCaptcha",
                code:{
                    required: true,
                    minlength: 4,
                    remote: {
                        url: "check-email.php",     //后台处理程序
                        //type: "post",               //数据发送方式
                        //dataType: "json",           //接受数据格式
                        data: {                     //要传递的数据
                            tel: function() {
                                return $("#tel").val();
                            }
                        }
                    }
                },
                password: {
                    required: true,
                    minlength: 5
                },
                rePassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                }
                // topic: {
                //     required: "#newsletter:checked",
                //     minlength: 2
                // },
                // agree: "required"
            },
            messages: {
                // firstname: "请输入您的名字",
                // lastname: "请输入您的姓氏",
                username: {
                    required: "请输入用户名",
                    minlength: "用户名必需由两个字母组成",
                    remote: "用户名已存在"
                },
                password: {
                    required: "请输入密码",
                    minlength: "密码长度不能小于 5 个字母"
                },
                rePassword: {
                    required: "请输入密码",
                    minlength: "密码长度不能小于 5 个字母",
                    equalTo: "两次密码输入不一致"
                },
                email: "请输入一个正确的邮箱"
            //     // agree: "请接受我们的声明",
            //     // topic: "请选择两个主题"
            },
            //修改错误提示标签
            errorElement:'span'
        })
    });

    function bindPhoneNum(){
        //启用输入框
        $('#code').prop('disabled',false);

        var time=30;
        var interval = setInterval(function(){
            time--;
            if(time<=0){
                clearInterval(interval);
                var html = '获取验证码';
                $('#get_captcha').prop('disabled',false);
            } else{
                var html = time + ' 秒后再次获取';
                $('#get_captcha').prop('disabled',true);
            }

            $('#get_captcha').val(html);
        },1000);
    }

    $('#get_captcha').click(function () {
        var tel = $('#tel').val();
        $.get('<?=\yii\helpers\Url::to(['member/sms'])?>', {tel: tel}, function (data) {
            if (data == 'success') {
                //发送成功了
                $('#get-msm').html('已发送验证码');
            } else {
                $('#get-msm').html('发送失败')
            }
        })
    });


    $("#change_captcha").click(function () {
        //获取新验证码图片的url
        $.getJSON('<?=\yii\helpers\Url::to(['site/captcha','refresh'=>1])?>',function(data){
            //将新验证码图片的地址更新到原验证码图片
            $("#img_captcha").attr('src',data.url);
            //hash保存//给后台验证、、因为这个验证码只能用一次，到后台就会失效
            $('body').data('captcha',data.hash1);
        });
    });
    $("#change_captcha").click();
    //自定义验证方法
    jQuery.validator.addMethod("validateCaptcha", function(value, element) {
        var v = value.toLowerCase();
        for (var i = v.length - 1, h = 0; i >= 0; --i) {
            h += v.charCodeAt(i);
        }
        var hash = $('body').data('captcha');
        return h==hash;//返回验证结果 true false
    }, "验证码错误");


</script>
</body>
</html>
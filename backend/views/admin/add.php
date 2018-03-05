<?php
$form = \yii\bootstrap\ActiveForm::begin();//表单开始<form>
echo $form->field($model,'username')->textInput();//通过模型生成输入框
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'email')->textInput();//通过模型生成输入框
//echo $form->field($model,'password_reset_token')->textInput();//令牌重置密码
//echo $form->field($model,'created_at')->textInput();//注册时间
//echo $form->field($model,'updated_at')->textInput();//修改时间
//echo $form->field($model,'last_login_time')->textInput();//最后登录时间
//echo $form->field($model,'last_login_ip')->textInput();//最后登录IP
//验证码
//echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
//    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>'
//]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();//表单结束</form>
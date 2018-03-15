<?php
$form = \yii\bootstrap\ActiveForm::begin();//表单开始<form>
echo $form->field($model,'username')->textInput();//通过模型生成输入框
echo $form->field($model,'oldPassword')->passwordInput();//旧密码
echo $form->field($model,'newPassword')->passwordInput();//新密码
echo $form->field($model,'rePassword')->passwordInput();//确认密码

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();//表单结束</form>
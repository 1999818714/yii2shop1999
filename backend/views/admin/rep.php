<?php
$form = \yii\bootstrap\ActiveForm::begin();//表单开始<form>
echo $form->field($model,'password')->passwordInput();//重置的密码
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();//表单结束</form>
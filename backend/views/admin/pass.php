<?php
$form = \yii\bootstrap\ActiveForm::begin();//表单开始<form>
echo $form->field($model,'username')->textInput();//通过模型生成输入框
echo $form->field($model,'password')->passwordInput();

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();//表单结束</form>
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/26
 * Time: 15:35
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'imgFile')->fileInput();
echo $form->field($model,'sort')->textInput();

echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\bootstrap\ActiveForm::end();
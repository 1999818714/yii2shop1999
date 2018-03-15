<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'url')->dropDownList(\backend\models\Menu::getPermissionOptions());
echo $form->field($model,'parent_id')->dropDownList($menu);
echo $form->field($model,'sort')->textInput();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
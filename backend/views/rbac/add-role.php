<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'description')->textInput();
//角色的权限
echo $form->field($model,'permissions')->checkboxList(\backend\models\RoleForm::getPermissionOptions());
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\bootstrap\ActiveForm::end();
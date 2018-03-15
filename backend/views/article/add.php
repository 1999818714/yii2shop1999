<?php
/**
 * @var $this \yii\web\View;
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'article_category_id')->dropDownList(\backend\models\Article::getArticlenameName());
echo $form->field($model,'sort')->textInput();
echo $form->field($article_detail,'content')->textarea();
echo '<button type="submit" class="btn btn-primary">提交</button>';
\yii\bootstrap\ActiveForm::end();
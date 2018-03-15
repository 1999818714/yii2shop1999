<?php


namespace frontend\controllers;


use frontend\models\Address;
use yii\web\Controller;

class AddressController extends Controller
{
//    public $layout = 'address';

    //添加地址
    public function actionAdd(){
        $model = new Address();
        $addresses = Address::find()->all();
        $request = \Yii::$app->request;
        if($request->isPost){
            var_dump($model);die();
            $model->load($request->post());
            $model->province = $_POST['province'];
            $model->city = $_POST['city'];
            $model->area = $_POST['area'];
            $model->save();
            if($model->validate()){
                if($model->flag){
                    $status1 = Address::find()->where(['flag'=>1])->all();

                    foreach($status1 as $status){
                        $status->flag = 0;
                        $status->update();
                    }
                    $model->flag = 1;
                }
                $model->member_id = \Yii::$app->user->id;
                $model->save();
                \Yii::$app->session->setFlash('success','添加地址成功');
                return $this->refresh();
            }
        }
        return $this->render('address',['model'=>$model,'addresses'=>$addresses]);
    }

    //修改地址
    public function actionEdit($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $address = Address::find()->all();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->province = $_POST['province'];
            $model->city = $_POST['city'];
            $model->area = $_POST['area'];
            $model->save();
            if($model->validate()){
                if($model->flag){
                    $status1 = Address::find()->where(['flag'=>1])->all();

                    foreach($status1 as $status){
                        $status->flag = 0;
                        $status->update();
                    }
                    $model->flag = 1;
                }
                $model->member_id = \Yii::$app->user->id;
                $model->save();
                \Yii::$app->session->setFlash('success','修改地址成功');
                return $this->refresh();
            }
        }
        return $this->render('address',['model'=>$model,'address'=>$address]);
    }
//删除地址
    public function actionDelete($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除地址成功');
        return $this->redirect(['address/add']);
    }

    public function actionCheck($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $status1 = Address::find()->where(['flag'=>1])->all();

        foreach($status1 as $status){
            $status->flag = 0;
            $status->update();
        }
        $model->flag = 1;
        $model->save();
        \Yii::$app->session->setFlash('success','设置默认地址成功');
        return $this->redirect(['address/add']);
    }
}
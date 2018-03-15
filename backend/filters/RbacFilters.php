<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/7/007
 * Time: 15:04
 */

namespace backend\filters;


use yii\base\ActionFilter;
use yii\web\HttpException;

class RbacFilters extends ActionFilter
{
    //控制器动作执行前
    public function beforeAction($action)
    {
        //测试当前用户的权限
//        return \Yii::$app->user->can($action->uniqueId);
        //return true;//放行
        //return false;//拦截

        if(!\Yii::$app->user->can($action->uniqueId)){
            //如果用户没有登录，就先引导用户先登录
            if(\Yii::$app->user->isGuest){
                //是游客时就登录
                //必须加send方法,避免return true
                return $action->controller->redirect(\Yii::$app->user->loginUrl)->send();
            }
            throw new HttpException(403,'对不起，你没有该操作权限');
        }
        return true;

    }
}
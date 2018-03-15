<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/8/008
 * Time: 14:33
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Menu extends ActiveRecord
{

    public static function tableName(){
        return 'menu';
    }

/**
* @inheritdoc
*/
    public function rules()
    {
        return [
            [['name', 'parent_id', 'url','sort'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'parent_id' => '上级菜单',
            'url' => '地址(路由)',
            'sort' => '排序',
        ];
    }

    //获取所有权限
    public static function getPermissionOptions(){
        $permissions = \Yii::$app->authManager->getPermissions();
         $menus = ArrayHelper::map($permissions,'name','name');
        return ArrayHelper::merge(['0'=>'=请选择路由='],$menus);
    }


    public static function getMenus($menuItems){
        //根据当前用户的逻辑来获取菜单
        //遍历所有菜单,判断当前用户是否有对应权限
        $menus = self::find()->where(['parent_id'=>0])->all();
        foreach ($menus as $menu){
            $items = [];
            $children = self::find()->where(['parent_id'=>$menu->id])->all();
            foreach ($children as $child){
                //只添加有权限的二级菜单
                if(\Yii::$app->user->can($child->url))
                    $items[] = ['label' => $child->name, 'url' => [$child->url]];
            }
            //只显示有子菜单的一级菜单
            if($items)
                $menuItems[] = ['label'=>$menu->name,'items'=>$items];
        }

        return $menuItems;
    }


}
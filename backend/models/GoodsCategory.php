<?php

namespace backend\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "goods_category".
 *
 * @property int $id
 * @property int $tree 数id
 * @property int $lft 左值
 * @property int $rgt 右值
 * @property int $depth 层级
 * @property string $name 名称
 * @property int $parent_id 上级分类
 * @property string $intro 简介
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree', 'lft', 'rgt', 'depth', 'parent_id'], 'integer'],
            [['name', 'parent_id'], 'required'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => '数id',
            'lft' => '左值',
            'rgt' => '右值',
            'depth' => '层级',
            'name' => '名称',
            'parent_id' => '上级分类id',
            'intro' => '简介',
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',//多棵树，必须指定tree属性
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new GoodsCategoryQuery(get_called_class());
    }


    /**
     * hasOne参数 1. 关联对象的类名
     * 参数2 [key=>value] key 表示关联对象的主键  value 表示关联对象在当前对象的字段

     * hasMany参数 参数1 关联对象的类名
     * 参数2 ['key'=>'value'] key  关联对象的主键  value 关联对象在中间表的关联字段
     * viaTable 指定中间表 参数1 中间表名
     * 参数2 ['key'=>'value'] key 当前对象在中间表的关联字段  value 当前对象的主键
     */

    public function getCates(){
        return $this->hasMany(self::class,['parent_id'=>'id']);
    }



}

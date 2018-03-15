<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 商品名称
 * @property string $sn 货号
 * @property string $logo LOGO图片
 * @property int $goods_category_id 商品分类id
 * @property int $brand_id 品牌分类
 * @property string $market_price 市场价格
 * @property string $shop_price 商品价格
 * @property int $stock 库存
 * @property int $is_on_sale 是否在售1在售0下架
 * @property int $status 状态 1正常 0回收站
 * @property int $sort 排序
 * @property int $create_time 添加时间
 * @property int $view_times 浏览次数
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time', 'view_times'], 'integer'],
            [['name', 'sn'], 'string', 'max' => 20],
            [['logo', 'market_price', 'shop_price'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '货号',
            'logo' => 'Logo图片',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '添加时间',
            'view_times' => '浏览次数',
        ];
    }

    public static function getBrandName(){
        $brands = Brand::find()->all();
        $brand_name = [];
        foreach ($brands as $brand){
            $brand_name[$brand->id]=$brand->name;
        }
        return $brand_name;
    }


    //根据商品id获取商品分类
    public static function getGoodsCategoryById($id){
        $goods = GoodsCategory::findOne(['id'=>$id]);

        return $goods->name;
    }
    //根据商品id获取商品
    public static function getBrandById($id){
        $brand = Brand::findOne(['id'=>$id]);

        return $brand->name;
    }


//    public function transactions()
//    {
//        return [
//            self::SCENARIO_DEFAULT => self::OP_ALL,
//        ];
//    }

//    public static function find()
//    {
//        return new GoodsCategoryQuery(get_called_class());
//    }


    public function getCates(){
        return $this->hasMany(self::class,['goods_category_id'=>'id']);
    }

    //这个在前台订单页面有用
    public function logo(){
        if(strpos($this->logo,'http://www.yii2shop.com') === false){//没找到
//            return   Yii::$app->params['backend_logo'].$this->logo;
            return   "http://www.yii2shop.com".$this->logo;
        }
        return $this->logo;
    }

}

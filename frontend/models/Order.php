<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $member_id 用户ID
 * @property string $name 收货人
 * @property string $province 省
 * @property string $city 市
 * @property string $area 县
 * @property string $address 详细地址
 * @property string $tel 联系电话
 * @property string $delivery_id 配送方式id
 * @property string $delivery_name 配送方式名称
 * @property string $delivery_price 配送方式价格
 * @property string $payment_id 支付方式ID
 * @property string $payment_name 支付方式
 * @property string $total 订单金额
 * @property int $status 订单状态（0已取消1待付款2待发货3待收货4完成）
 * @property string $trode_no 第三方支付的交易号
 * @property string $create_time 添加时间
 */
class Order extends \yii\db\ActiveRecord
{
//    public static $method=[
//        1=>['name'=>'顺丰','price'=>'40','intro'=>'很快'],
//        2=>['name'=>'圆通','price'=>'20','intro'=>'一般'],
//        3=>['name'=>'申通','price'=>'10','intro'=>'不错']
//    ];
//    public static $pays=[
//        1=>['name'=>'货到付款','intro'=>'送货上门后再收款，支持现金、POS机刷卡、支票支付'],
//        2=>['name'=>'在线支付','intro'=>'即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
//        3=>['name'=>'上门自提','intro'=>'自提时付款，支持现金、POS刷卡、支票支付'],
//        4=>['name'=>'邮局汇款','intro'=>'通过快钱平台收款 汇款后1-3个工作日到账']
//    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'delivery_id', 'payment_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'total'], 'number'],
            [['name', 'province', 'city', 'area', 'address', 'delivery_name', 'payment_name'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
            [['trode_no'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户ID',
            'name' => '收货人',
            'province' => '省',
            'city' => '市',
            'area' => '县',
            'address' => '详细地址',
            'tel' => '电话',
            'delivery_id' => '配送方式id',
            'delivery_name' => '配送方式的名称',
            'delivery_price' => '配送方式价格',
            'payment_id' => '支付方式id',
            'payment_name' => '支付方式',
            'total' => '订单金额',
            'status' => '状态',
            'trode_no' => '第三方交易号',
            'create_time' => '创建时间',
        ];
    }
}

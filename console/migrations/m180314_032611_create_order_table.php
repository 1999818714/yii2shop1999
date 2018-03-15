<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180314_032611_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->comment('用户ID'),
            'name'=>$this->string()->comment('收货人'),
            'province'=>$this->string()->comment('省'),
            'city'=>$this->string()->comment('市'),
            'area'=>$this->string()->comment('县'),
            'address'=>$this->string(255)->comment('详细地址'),
            'tel'=>$this->string(11)->comment('联系电话'),
            'delivery_id'=>$this->integer()->unsigned()->comment('配送方式id'),
            'delivery_name'=>$this->string()->comment('配送方式名称'),
            'delivery_price'=>$this->decimal()->comment('配送方式价格'),
            'payment_id'=>$this->integer()->unsigned()->comment('支付方式ID'),
            'payment_name'=>$this->string()->comment('支付方式'),
            'total'=>$this->decimal()->comment('订单金额'),
            'status'=>$this->integer()->comment('订单状态（0已取消1待付款2待发货3待收货4完成）'),
            'trode_no'=>$this->string(30)->comment('第三方支付的交易号'),
            'create_time'=>$this->integer()->unsigned()->comment('添加时间')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
    }
}

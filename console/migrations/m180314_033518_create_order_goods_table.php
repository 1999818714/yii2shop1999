<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_goods`.
 */
class m180314_033518_create_order_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_goods', [
            'id' => $this->primaryKey(),
            'order_id'=>$this->integer()->comment('订单ID'),
            'goods_id'=>$this->integer()->comment('商品ID'),
            'goods_name'=>$this->string(255)->comment('商品名称'),
            'logo'=>$this->string(255)->comment('LOGO'),
            'price'=>$this->decimal(10,2)->comment('价格'),
            'amount'=>$this->integer()->comment('数量'),
            'total'=>$this->decimal(10,2)->comment('小计'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_goods');
    }
}

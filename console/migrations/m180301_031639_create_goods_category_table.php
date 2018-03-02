<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m180301_031639_create_goods_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->comment('数id'),
            'ift' => $this->integer()->comment('左值'),
            'rgt' => $this->integer()->comment('右值'),
            'depth' => $this->integer()->comment('层级'),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'parent_id' => $this->integer()->notNull()->comment('上级分类'),
            'intro' => $this->text()->comment('简介'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_category');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_detail`.
 */
class m180228_133318_create_article_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_detail', [
            'article_id' => $this->primaryKey(),
            'content' => $this->text()->comment('内容'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article_detail');
    }
}

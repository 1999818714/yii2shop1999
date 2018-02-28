<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $intro 简介
 * @property int $article_category_id 文章分类id
 * @property int $sort 排序
 * @property int $is_deleted 状态
 * @property int $create_time 创建时间
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sort', 'is_deleted'], 'required'],
            [['intro'], 'string'],
            [['article_category_id', 'sort', 'is_deleted', 'create_time'], 'integer'],
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
            'name' => '名称',
            'intro' => '简介',
            'article_category_id' => '文章分类id',
            'sort' => '排序',
            'is_deleted' => '状态',
            'create_time' => '添加时间',
        ];
    }
}

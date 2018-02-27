<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $is_deleted
 */
class Brand extends \yii\db\ActiveRecord
{
    //处理图片
    public $imgFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sort', 'is_deleted'], 'required'],
            [['intro'], 'string'],
            [['sort', ], 'integer'],
            [['name'], 'string', 'max' => 50],
            ['imgFile','file','extensions' => ['png','jpg','gif'],'skipOnEmpty'=>1],
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
            'imgFile' => 'LOGO',
            'sort' => '排序',
            'is_deleted' => '状态',

        ];
    }
}

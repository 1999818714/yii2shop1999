<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_gallery".
 *
 * @property int $id
 * @property int $goods_id 商品id
 * @property string $path 图片地址
 */
class GoodsGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'path' => 'Path',
        ];
    }
}

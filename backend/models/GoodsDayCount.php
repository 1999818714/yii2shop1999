<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_day_count".
 *
 * @property int $id
 * @property string $day 日期
 * @property int $count 商品数
 */
class GoodsDayCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_day_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day'], 'safe'],
            [['count'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => '日期',
            'count' => '商品数',
        ];
    }
}

<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_ps".
 *
 * @property int $id
 * @property string $name 运送方式名称
 * @property string $price 价格
 * @property string $intro 简介
 */
class OrderPs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_ps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['name', 'intro'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '配送方式名称',
            'price' => '配送价格',
            'intro' => '配送简介',
        ];
    }
}

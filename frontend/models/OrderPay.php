<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_pay".
 *
 * @property int $id
 * @property string $name 支付方式名称
 * @property string $intro 支付方式简介
 */
class OrderPay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'name' => '支付方式名称',
            'intro' => '支付方式简介',
        ];
    }
}

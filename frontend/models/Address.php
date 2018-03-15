<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 16:14
 */

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Address extends ActiveRecord
{
    public $flag;//默认地址
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'province', 'city', 'area', 'tel', 'site'], 'required'],
            [['member_id', 'flag'], 'integer'],
            [['name', 'province', 'city', 'area', 'site'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收 货 人',
            'member_id' => '用户ID',
            'province' => '省',
            'city' => '市',
            'area' => '县',
            'tel' => '手机号码',
            'site' => '详细地址',
            'flag' => '默认地址',
        ];
    }
}
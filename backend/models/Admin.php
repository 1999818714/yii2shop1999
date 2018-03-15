<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/4/004
 * Time: 10:57
 */

namespace backend\models;


use yii\bootstrap\ActiveForm;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\Response;

class Admin extends ActiveRecord implements IdentityInterface
{

    public $role;
    //定义场景
//    const SCENARIO_ADD = 'add';
//    const SCENARIO_EDIT = 'edit';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password_reset_token', 'created_at', 'last_login_time'], 'integer'],
            [['username', 'password', 'email'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['password', 'auth_key', 'email', 'last_login_ip'], 'string', 'max' => 255],
//            ['username', 'unique', 'targetClass' => '\backend\models\admin', 'message' => '用户名已存在.'],
            ['role','safe']
            //添加时 必须填密码
            //修改时 可以不填
            //场景(添加,修改)
//            ['password','required','on'=>[self::SCENARIO_ADD]],//配置场景,只在添加场景生效//safe意思在添加时不做验证
//            ['password','safe','on'=>[self::SCENARIO_EDIT]],//配置场景,只在修改场景生效//safe意思在修改时不做验证
        ];
    }

    public function validateUsername(){
                if (\Yii::$app->request->isAjax) {
                    \Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($this);
                } //ajax提交过来的会直接进行验证
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => '盐',
            'password' => '密码',
            'password_reset_token' => '令牌重置密码',
            'email' => '邮箱',
            'status' => '状态',//1正常0删除
            'created_at' => '注册添加时间',
            'updated_at' => '修改时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
        ];
    }

    public static function getRoles(){
        $authManager = \Yii::$app->authManager->getRoles();
        return ArrayHelper::map($authManager,'name','name');
    }
    //获取角色
//    public static function getRoles()
//    {
//        $authManager = \Yii::$app->authManager;
//        $roles = $authManager->getRoles();
//        $tmp = [];
//        foreach ($roles as $role) {
//            $tmp[$role->name] = $role->name;
//        }
//        return $tmp;
//    }

    //添加角色
//    public static function addRole(){
//        $authManager = \Yii::$app->authManager;
//        if(is_array($this->role)){
//            foreach ($this->role as $role){
//                $authManager->assign($authManager->getRole($role),$this->id);
//            }
//        }
//    }
//修改角色
//    public static function editRole(){
//        $authManager = \Yii::$app->authManager;
//        $authManager->revokeAll($this->id);
//        if(is_array($this->role)){
//            foreach ($this->role as $role){
//                $authManager->assign($authManager->getRole($role),$this->id);
//            }
//        }
//    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }


}
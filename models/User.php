<?php
namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\components\behaviors\CacheBehavior;
/**
 * Class User
 * @package app\models
 * @property int $id
 * @property string $username
 * @property email $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string $access_token
 * @property int $created_at
 * @property int $updated_at
 *
 * @property-write $password -> setPassword()
 */
class User extends ActiveRecord implements IdentityInterface
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            CacheBehavior::class => [
                'class' => CacheBehavior::class,
            ],
        ];
    }
    public static function tableName()
    {
        return 'user';
    }


    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }


    public function getAuthKey()
    {
        return $this->auth_key;
    }
    public function validateAuthKey($authKey)
    {
        return $this->auth_key = $authKey;
    }
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }
    public  function validatePassword($password){
        //return $this->password === $password;
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    public static function findOneCache()
    {
        if (Yii::$app->cache->exists(\Yii::$app->user->identity) === false) {
            Yii::$app->cache->set(\Yii::$app->user->identity);
            return\Yii::$app->user->identity;
        } else {
            return Yii::$app->cache->get(\Yii::$app->user->identity);
        }
    }
}
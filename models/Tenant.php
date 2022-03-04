<?php

namespace app\models;

use app\Infrastructure\DB\RecordLandlord;
use Yii;
use yii\web\IdentityInterface;

class Tenant extends RecordLandlord implements IdentityInterface
{

    public static function tableName()
    {
        return '{{%tenants}}';
    }
    
    public static function findDatabaseByHost($host)
    {
        $host = str_replace('/', '', $host);

        return static::findOne(['domain' => $host]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function configure()
    {
        Yii::$app->db->close();
        Yii::$app->db->dsn = "mysql:host=mysql;dbname={$this->database}";
        Yii::$app->db->open();

        return $this;
    }

    
    public static function loginByAccessToken($id)
    {
        return true;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::findAll([]) as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

}
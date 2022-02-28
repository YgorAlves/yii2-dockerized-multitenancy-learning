<?php

namespace app\models;

use app\components\ActiveRecordLandlord;
use Yii;
use yii\helpers\Url;

class Tenant extends ActiveRecordLandlord
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

    public static function findIdentity($id)
    {
        return static::findOne($id);
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

}
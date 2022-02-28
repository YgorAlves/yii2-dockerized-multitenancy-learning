<?php 

namespace app\components;

class ActiveRecordLandlord extends \yii\db\ActiveRecord
{
    public static function getDb ()
    {
        return \Yii::$app->dbLandlord;
    }
}
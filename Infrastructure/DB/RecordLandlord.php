<?php 

namespace app\Infrastructure\DB;

use Yii;
use yii\db\ActiveRecord;

class RecordLandlord extends ActiveRecord
{
    public static function getDb ()
    {
        return Yii::$app->dbLandlord;
    }
}

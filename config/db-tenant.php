<?php

use app\models\Tenant;
use yii\helpers\Url;

function getTenantDatabase() {
    $db = "test";
    if (Yii::$app instanceof \yii\web\Application) {
        $userTenant = Tenant::findDatabaseByHost(Url::home(''));
        $db = $userTenant?->database ?? 'test';
    }
    return $db;
}

return function () {

    return new yii\db\Connection([
        'dsn' => "mysql:host=mysql;dbname=".getTenantDatabase()."",
        'username' => 'root',
        'password' => 'consys',
    ]);
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
};

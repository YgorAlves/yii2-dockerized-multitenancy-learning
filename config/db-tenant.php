<?php

use app\models\Tenant;
use yii\helpers\Url;

function getTenantDatabase() {
    if (Yii::$app instanceof \yii\web\Application) {
        $userTenant = Tenant::findDatabaseByHost(Url::home(''));
        $db = $userTenant?->database;
    }
    return $db ?? 'test';
}

return function () {
    return new yii\db\Connection([
        'dsn' => "mysql:host=mysql;dbname=".getTenantDatabase()."",
        'username' => 'root',
        'password' => 'consys',
        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ]);
};

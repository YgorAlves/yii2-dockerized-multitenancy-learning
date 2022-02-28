<?php

namespace app\commands;

use app\models\Tenant;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class TenantsMigrateController extends Controller
{

    public $fresh;
    public $seed;

    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['fresh', 'seed']);
    }

    public function actionIndex($tenant = "")
    {
        if ($tenant) {
            $this->migrate(
                Tenant::findOne(['database' => $tenant])
            );
        } else {
            array_map(fn(Tenant $tenant) => $this->migrate($tenant), Tenant::find()->all());
        }
        
        return ExitCode::OK;
    }

    public function migrate(Tenant $tenant)
    {
        Yii::$app->dbLandlord->createCommand("CREATE DATABASE IF NOT EXISTS {$tenant->database} CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci")->execute();
        $tenant->configure();

        $this->stdout("\n");
        $this->stdout("----------------------------------------------\n");
        $this->stdout("Migrating Tenant #{$tenant->id} ({$tenant->name})\n");
        $this->stdout("----------------------------------------------\n");
        
        \Yii::$app->runAction($this->fresh ? 'migrate/fresh' : 'migrate', ['migrationPath' => '@app/migrations', 'interactive' => false ]);
        
        if ($this->seed) {
            \Yii::$app->runAction('seed', []);
        }
    }

}

<?php

namespace app\commands;

use app\models\Tenant;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
    public function actionIndex()
    {
        $faker = \Faker\Factory::create();

        $this->seedUsers($faker, 2);

        return ExitCode::OK;
    }

    public function actionTenants(int $quantity)
    {
        $faker = \Faker\Factory::create();

        $tenant = new Tenant();

        for ($i = 0; $i < $quantity; $i++) {
            $tenant->setIsNewRecord(true);
            $tenant->id = null;
            
            $username = $faker->domainWord();

            $tenant->name = $username;
            $tenant->domain = $faker->domainName();
            $tenant->database = $username;
            $tenant->save();
        }
        
    }

    private function seedUsers(\Faker\Generator $faker, int $quantity)
    {
        $faker = \Faker\Factory::create();

        $user = new User();
        $user->username = 'test';
        $user->password = 'test';
        $user->email = 'test@test';
        $user->save();
        

        for ($i = 0; $i < $quantity; $i++) {
            $user->setIsNewRecord(true);
            $user->id = null;
            
            $user->username = $faker->userName();
            $user->password = $faker->password();
            $user->email = $faker->email();
            $user->save();
        }
    }
    

}

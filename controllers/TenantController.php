<?php

namespace app\controllers;

use app\models\Tenant;
use app\behaviours\Apiauth;

class TenantController extends RestController
{

        /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
        return $actions;
    }


    public function actionView($id)
    {
        return Tenant::findOne($id);
    }

    public function actionIndex()
    {
        $tenants = Tenant::find()->all();
        return $tenants;
    }
}

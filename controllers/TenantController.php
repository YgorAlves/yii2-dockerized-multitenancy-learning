<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\Tenant;
use yii\filters\auth\HttpBasicAuth;

class TenantController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        
        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
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

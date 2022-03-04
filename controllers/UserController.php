<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\User;
use yii\filters\auth\HttpBasicAuth;

class UserController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

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
        return User::findOne($id);
    }

    public function actionIndex()
    {
        return User::find()->all();
    }
}

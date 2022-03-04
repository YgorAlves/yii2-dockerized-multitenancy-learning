<?php

namespace app\controllers;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\Response;

class RestController extends Controller
{
    public $request;
    public $enableCsrfValidation = false;
    public $headers;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                // 'Access-Control-Allow-Origin' => ['*', 'http://consys.local.com:8100','http://localhost:8100'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Expose-Headers' => []
            ]
        ];

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'except' => ['options'],
            'authMethods' => [
                // ['class' => HttpHeaderAuth::class, 'header' => 'api_token'],
                // ['class' => QueryParamAuth::class, 'tokenParam' => 'api_token'],
                // ['class' => PostParamAuth::class, 'tokenParam' => 'api_token'],
                ['class' => HttpBearerAuth::class]
            ],
        ];

        return $behaviors;
    }

    public function init()
    {
        $this->request = json_decode(file_get_contents('php://input'), true);

        if($this->request&&!is_array($this->request)){
            Yii::$app->api->sendFailedResponse(['Invalid Json']);
        }
        
    }

    public function actionOptions ()
    {
        if (\Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
           \Yii::$app->getResponse()->setStatusCode(405);
        }
        \Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST');
    }
}
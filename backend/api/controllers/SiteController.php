<?php

namespace api\controllers;

use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return [
            'ok' => true,
            'service' => 'epa-ecommerce-platform-api',
            'version' => 'v1',
            'time' => date(DATE_ATOM),
        ];
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception === null) {
            Yii::$app->response->statusCode = 500;
            return [
                'name' => 'Error',
                'message' => 'An unexpected error occurred.',
                'status' => 500,
            ];
        }

        $status = 500;
        if ($exception instanceof \yii\web\HttpException) {
            $status = (int)$exception->statusCode;
        }

        Yii::$app->response->statusCode = $status;

        $payload = [
            'name' => (new \ReflectionClass($exception))->getShortName(),
            'message' => YII_DEBUG ? (string)$exception->getMessage() : 'An unexpected error occurred.',
            'status' => $status,
        ];

        if (YII_DEBUG) {
            $payload['type'] = get_class($exception);
            $payload['file'] = $exception->getFile();
            $payload['line'] = $exception->getLine();
        }

        return $payload;
    }
}

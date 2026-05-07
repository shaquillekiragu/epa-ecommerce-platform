<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use common\models\User;
use common\models\Usertoken;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
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

    public function actionRegister()
    {
        $body = Yii::$app->request->getBodyParams();

        $email = (string) ($body['email'] ?? '');
        $password = (string) ($body['password'] ?? '');

        if ($email === '' || $password === '') {
            throw new BadRequestHttpException('Email and password are required.');
        }

        if (User::findByEmail($email) !== null) {
            throw new BadRequestHttpException('Email already exists.');
        }

        $user = new User();
        $user->load($body, '');
        $user->setPassword($password);
        $user->is_active = true;
        $user->allow_update = true;
        $user->allow_delete = true;

        // Prevent self-service role escalation by default.
        if (isset($body['role']) && $body['role'] === 'merchant') {
            $user->role = 'customer';
        }

        if (!$user->save()) {
            throw new BadRequestHttpException(json_encode($user->errors));
        }

        return [
            'user' => [
                'id' => $user->id,
                'role' => $user->role,
                'email' => $user->email,
                'full_name' => $user->fullName,
            ],
        ];
    }

    public function actionOptions()
    {
        return ['ok' => true];
    }

    public function actionLogin()
    {
        $body = Yii::$app->request->getBodyParams();
        $email = (string) ($body['email'] ?? '');
        $password = (string) ($body['password'] ?? '');

        if ($email === '' || $password === '') {
            throw new BadRequestHttpException('Email and password are required.');
        }

        $user = User::findByEmail($email);
        if ($user === null || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException('Invalid credentials.');
        }

        if (!$user->is_active) {
            throw new UnauthorizedHttpException('User is inactive.');
        }

        $raw_token = Yii::$app->security->generateRandomString(64);
        $token_hash = hash('sha256', $raw_token);

        $token = new Usertoken();
        $token->user_id = (int) $user->id;
        $token->token_hash = $token_hash;
        $token->expires_at = date('Y-m-d H:i:s', time() + (60 * 60 * 24 * 30)); // 30 days

        if (!$token->save()) {
            throw new BadRequestHttpException('Could not create token.');
        }

        return [
            'token' => $raw_token,
            'token_type' => 'bearer',
            'expires_at' => $token->expires_at,
            'user' => [
                'id' => $user->id,
                'role' => $user->role,
                'email' => $user->email,
                'full_name' => $user->fullName,
            ],
        ];
    }

    public function actionLogout()
    {
        $auth_header = (string) Yii::$app->request->getHeaders()->get('Authorization', '');
        if ($auth_header === '' || stripos($auth_header, 'Bearer ') !== 0) {
            throw new UnauthorizedHttpException('Missing bearer token.');
        }

        $raw_token = trim(substr($auth_header, 7));
        if ($raw_token === '') {
            throw new UnauthorizedHttpException('Missing bearer token.');
        }

        $token_hash = hash('sha256', $raw_token);
        $token = Usertoken::findOne(['token_hash' => $token_hash]);
        if ($token === null) {
            return ['ok' => true];
        }

        $token->revoked_at = date('Y-m-d H:i:s');
        $token->save(false, ['revoked_at']);

        return ['ok' => true];
    }
}

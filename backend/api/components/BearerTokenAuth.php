<?php

namespace api\components;

use Yii;
use yii\web\UnauthorizedHttpException;
use yii\filters\auth\AuthMethod;
use common\models\User;
use common\models\Usertoken;

class BearerTokenAuth extends AuthMethod
{
    public function authenticate($user, $request, $response)
    {
        $authHeader = (string) $request->getHeaders()->get('Authorization', '');
        
        if ($authHeader === '' || stripos($authHeader, 'Bearer ') !== 0) {
            return null;
        }

        $token = trim(substr($authHeader, 7));

        if ($token === '') {
            return null;
        }

        $tokenHash = hash('sha256', $token);

        /** @var Usertoken|null $userToken */
        $userToken = Usertoken::findOne(['token_hash' => $tokenHash]);

        if ($userToken === null || $userToken->isRevoked || $userToken->isExpired) {
            throw new UnauthorizedHttpException('Invalid or expired token.');
        }

        /** @var User|null $identity */
        $identity = $userToken->user;

        if ($identity === null || !$identity->is_active) {
            throw new UnauthorizedHttpException('User is inactive.');
        }

        $userToken->last_used_at = date('Y-m-d H:i:s');
        $userToken->save(false, ['last_used_at']);

        Yii::$app->user->setIdentity($identity);

        return $identity;
    }
}

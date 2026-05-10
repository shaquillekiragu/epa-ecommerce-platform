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
        $auth_header = (string) $request->getHeaders()->get('Authorization', '');
        
        if ($auth_header === '' || stripos($auth_header, 'Bearer ') !== 0) {
            return null;
        }

        $token = trim(substr($auth_header, 7));

        if ($token === '') {
            return null;
        }

        $token_hash = hash('sha256', $token);

        /** @var Usertoken|null $user_token */
        $user_token = Usertoken::findOne(['token_hash' => $token_hash]);

        if ($user_token === null || $user_token->isRevoked || $user_token->isExpired) {
            throw new UnauthorizedHttpException('Invalid or expired token.');
        }

        /** @var User|null $identity */
        $identity = $user_token->user;

        if ($identity === null || !$identity->is_active) {
            throw new UnauthorizedHttpException('User is inactive.');
        }

        if (($identity->role ?? null) === 'superadmin') {
            throw new UnauthorizedHttpException('You are not allowed to access the storefront with this account type. Login to the superadmin dashboard.');
        }

        if (!in_array((string)$identity->role, ['customer', 'merchant'], true)) {
            throw new UnauthorizedHttpException('This account is not allowed to use the storefront API.');
        }

        $user_token->last_used_at = date('Y-m-d H:i:s');
        $user_token->save(false, ['last_used_at']);

        Yii::$app->user->setIdentity($identity);

        return $identity;
    }
}

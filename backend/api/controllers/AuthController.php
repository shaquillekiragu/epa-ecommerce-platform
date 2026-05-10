<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;
use common\models\User;
use common\models\Usertoken;

class AuthController extends Controller
{
    /**
     * Parsed body params. Handles JSON when Postman/clients omit Content-Type: application/json
     * (Yii would otherwise leave getBodyParams() empty).
     *
     * @return array<string, mixed>
     */
    private function getRequestBodyParams(): array
    {
        $request = Yii::$app->request;
        $params = $request->getBodyParams();

        if (is_array($params) && $params !== []) {
            return $params;
        }

        $raw = $request->getRawBody();

        if ($raw === '' || !is_string($raw)) {
            return [];
        }

        $trimmed = ltrim($raw);
        $contentType = (string) $request->getContentType();
        $looksLikeJson = $trimmed !== '' && ($trimmed[0] === '{' || $trimmed[0] === '[');

        if (stripos($contentType, 'json') !== false || $looksLikeJson) {
            $decoded = json_decode($raw, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }

    /**
     * Canonical composed Unicode (NFC) so the same visual password matches across clients
     * (browsers often send NFD for some characters; Postman/APIs may send NFC).
     */
    private function normalizePasswordUnicode(string $password): string
    {
        if ($password === '' || !class_exists(\Normalizer::class)) {
            return $password;
        }

        $normalized = \Normalizer::normalize($password, \Normalizer::FORM_C);

        return is_string($normalized) ? $normalized : $password;
    }

    /**
     * @return list<string>
     */
    private function loginPasswordCandidates(string $password_raw): array
    {
        $trimmed = trim($password_raw);
        $candidates = [
            $this->normalizePasswordUnicode($trimmed),
            $trimmed,
        ];

        if (class_exists(\Normalizer::class)) {
            $nfd_trimmed = \Normalizer::normalize($trimmed, \Normalizer::FORM_D);
            if (is_string($nfd_trimmed)) {
                $candidates[] = $nfd_trimmed;
            }
        }

        if ($password_raw !== $trimmed) {
            $candidates[] = $this->normalizePasswordUnicode($password_raw);
            $candidates[] = $password_raw;

            if (class_exists(\Normalizer::class)) {
                $nfd_raw = \Normalizer::normalize($password_raw, \Normalizer::FORM_D);
                if (is_string($nfd_raw)) {
                    $candidates[] = $nfd_raw;
                }
            }
        }

        $seen = [];
        $out = [];

        foreach ($candidates as $c) {
            if ($c === '' || array_key_exists($c, $seen)) {
                continue;
            }

            $seen[$c] = true;
            $out[] = $c;
        }

        return $out;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // yii\rest\Controller attaches CompositeAuth by default; keep these endpoints public.
        unset($behaviors['authenticator']);

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
        $body = $this->getRequestBodyParams();
        $email = mb_strtolower(trim((string) ($body['email'] ?? '')));
        $password_raw_register = (string) ($body['password'] ?? '');
        $password = $this->normalizePasswordUnicode(trim($password_raw_register));

        if ($email === '' || $password === '') {
            throw new BadRequestHttpException('Email and password are required.');
        }

        if (User::findByEmail($email) !== null) {
            throw new BadRequestHttpException('Email already exists.');
        }

        $safe = $body;

        foreach (['password', 'hashed_password', 'id'] as $key) {
            unset($safe[$key]);
        }

        $user = new User();
        $user->load($safe, '');
        $user->email = $email;
        $user->password = $password;
        $user->is_active = true;
        $user->allow_update = true;
        $user->allow_delete = true;

        $account_type = strtolower(trim((string)($body['account_type'] ?? 'customer')));

        if (!in_array($account_type, ['customer', 'merchant'], true)) {
            throw new BadRequestHttpException('Account type must be customer or merchant.');
        }

        $user->role = $account_type;

        if (!$user->save()) {
            throw new BadRequestHttpException(json_encode($user->errors));
        }

        $user->refresh();

        $verified_after_save = false;

        foreach ($this->loginPasswordCandidates($password_raw_register) as $candidate) {
            if ($user->validatePassword($candidate)) {
                $verified_after_save = true;
                break;
            }
        }

        if (!$verified_after_save) {
            throw new BadRequestHttpException(
                YII_DEBUG
                    ? 'Registration saved but password verification failed after reload. The stored hashed_password does not match any login-equivalent form of this password (check DB column / ORM).'
                    : 'Could not complete registration.'
            );
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
        $body = $this->getRequestBodyParams();
        $email = mb_strtolower(trim((string) ($body['email'] ?? '')));
        $password_raw = (string) ($body['password'] ?? '');
        $trimmed = trim($password_raw);

        if ($email === '' || $trimmed === '') {
            throw new BadRequestHttpException('Email and password are required.');
        }

        $user = User::findByEmail($email);

        if ($user === null) {
            $msg = YII_DEBUG
                ? 'Invalid credentials. (debug: no user row matches this email. Confirm URL is the storefront API, database, and JSON keys are "email" and "password".)'
                : 'Invalid credentials.';
            throw new UnauthorizedHttpException($msg);
        }

        $hash = trim((string) ($user->hashed_password ?? ''));

        if ($hash === '') {
            $msg = YII_DEBUG
                ? 'Invalid credentials. (debug: user has an empty hashed_password; re-register or fix the row.)'
                : 'Invalid credentials.';

            throw new UnauthorizedHttpException($msg);
        }

        $matched_plain = null;

        foreach ($this->loginPasswordCandidates($password_raw) as $candidate) {
            if ($user->validatePassword($candidate)) {
                $matched_plain = $candidate;
                break;
            }
        }

        $password_ok = $matched_plain !== null;

        if (!$password_ok) {
            $stored_preview = trim((string) ($user->hashed_password ?? ''));
            $looks_bcrypt_or_argon2 = str_starts_with($stored_preview, '$2')
                || str_starts_with($stored_preview, '$argon2');
            $msg = YII_DEBUG
                ? (
                    $looks_bcrypt_or_argon2
                        ? 'Invalid credentials. (debug: bcrypt/argon2 hash present but no login variant matched (password bytes differ from signup—try superadmin Password field, re-register, or if the password has accents/emoji, retry after deploy; we try NFC-normalized and raw forms).)'
                        : sprintf(
                            'Invalid credentials. (debug: stored length=%d; prefix=%s. If this is not a $2… or $argon2… hash, it may be legacy plaintext.)',
                            strlen($stored_preview),
                            json_encode(substr($stored_preview, 0, 16))
                        )
                )
                : 'Invalid credentials.';

            throw new UnauthorizedHttpException($msg);
        }

        $user->upgradePlaintextPasswordColumn((string) $matched_plain);

        if (!$user->is_active) {
            throw new UnauthorizedHttpException('User is inactive.');
        }

        if (($user->role ?? null) === 'superadmin') {
            throw new ForbiddenHttpException('You are not allowed to access the storefront with this account type. Login to the superadmin dashboard.');
        }

        if (!in_array((string)$user->role, ['customer', 'merchant'], true)) {
            throw new ForbiddenHttpException('This account is not allowed to use the storefront API.');
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

        $expires_ts = strtotime((string)$token->expires_at);
        $expires_at_iso = $expires_ts !== false ? gmdate('c', $expires_ts) : (string)$token->expires_at;

        return [
            'token' => $raw_token,
            'token_type' => 'bearer',
            'expires_at' => $expires_at_iso,
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

<?php

namespace common\validators;

use yii\validators\Validator;

final class ThumbnailValidator extends Validator
{
    public function validateAttribute($model, $attribute): void
    {
        $message = self::valueErrorMessage($model->$attribute);
        if ($message !== null) {
            $this->addError($model, $attribute, $message);
        }
    }

    public static function valueErrorMessage($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = (string) $value;
        if (preg_match('#^https?://#i', $value)) {
            if (filter_var($value, FILTER_VALIDATE_URL) === false) {
                return 'Thumbnail must be a valid URL.';
            }
            return null;
        }

        if (strpbrk($value, "\0\r\n") !== false) {
            return 'Invalid thumbnail value.';
        }

        if (!preg_match('/^[\p{L}\p{N}\s\-–—._~\/:&?=#%+]+$/u', $value)) {
            return 'Thumbnail must be a valid URL or a storage path (letters, numbers, common path punctuation only).';
        }

        return null;
    }
}

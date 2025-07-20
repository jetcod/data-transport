<?php

namespace Jetcod\DataTransport\Validations\Validators;

use Jetcod\DataTransport\Contracts\ValidatorInterface;

class UrlValidator implements ValidatorInterface
{
    public function validate($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $pattern = '~^
            (https?|ftp)://                                     # scheme
            (([\p{L}\p{N}\p{M}._%+-]+)@)?                       # user
            ([\p{L}\p{N}][\p{L}\p{N}-]{0,61}[\p{L}\p{N}]\.)+    # domain segments
            [\p{L}]{2,63}                                       # TLD
            (:\d{2,5})?                                         # port
            (/[^\s]*)?                                          # path
        $~ixu';

        if (!preg_match($pattern, $value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error.
     */
    public function getError(): string
    {
        return 'The value is not a valid URL.';
    }

    /**
     * Get the validation alias.
     */
    public function alias(): string
    {
        return 'url';
    }
}

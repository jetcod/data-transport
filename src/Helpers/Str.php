<?php

namespace Jetcod\DataTransport\Helpers;

class Str
{
    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];

    public static function studly($value)
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $words = explode(' ', static::replace(['-', '_'], ' ', $value));

        $studlyWords = array_map(fn ($word) => static::ucfirst($word), $words);

        return static::$studlyCache[$key] = implode($studlyWords);
    }

    /**
     * Replace the given value in the given string.
     *
     * @param array<string>|string $search
     * @param array<string>|string $replace
     * @param array<string>|string $subject
     * @param bool                 $caseSensitive
     *
     * @return string|string[]
     */
    public static function replace($search, $replace, $subject, $caseSensitive = true)
    {
        return $caseSensitive
                ? str_replace($search, $replace, $subject)
                : str_ireplace($search, $replace, $subject);
    }

    /**
     * Make a string's first character uppercase.
     *
     * @param string $string
     *
     * @return string
     */
    public static function ucfirst($string)
    {
        return static::upper(static::substr($string, 0, 1)) . static::substr($string, 1);
    }

    /**
     * Convert the given string to upper-case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function upper($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * Returns the portion of the string specified by the start and length parameters.
     *
     * @param string   $string
     * @param int      $start
     * @param null|int $length
     * @param string   $encoding
     *
     * @return string
     */
    public static function substr($string, $start, $length = null, $encoding = 'UTF-8')
    {
        return mb_substr($string, $start, $length, $encoding);
    }
}

<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use Doctrine\Inflector\Inflector;
use function bin2hex;
use function htmlentities;
use function implode;
use function is_string;
use function lcfirst;
use function mb_convert_case;
use function str_pad;
use function str_repeat;
use function str_split;
use function strlen;
use function strpos;
use function strtolower;
use function strtoupper;
use function substr;
use function trim;
use function ucfirst;
use function ucwords;
use function version_compare;
use function vsprintf;
use const ENT_QUOTES;
use const MB_CASE_TITLE;
use const STR_PAD_BOTH;

/**
 * Class StringUtil
 * @package Oopize\Util
 * @since   0.1
 */
final class StringUtil {
    public const
        OP_GT = '>',
        OP_GTE = '>=',
        OP_LT = '<',
        OP_LTE = '<=',
        OP_EQ = '==',
        OP_NEQ = '!=';

    /**
     * @var string
     */
    private static $encoding = 'UTF-8';

    /**
     * Checks if mbstring extension is loaded.
     *
     * @return bool
     * @deprecated in favor of Multibyte::isSupported()
     */
    private static function isMbstringLoaded(): bool {
        return Multibyte::isSupported();
    }

    /**
     * @param string $text
     * @param int    $position
     *
     * @return string|null
     */
    public function charAt(string $text, int $position = 0): ?string {
        $charMap = str_split($text);

        return $charMap[$position] ?? null;
    }

    /**
     * Safely converts the given string to uppercase.
     *
     * @param string      $string
     * @param string|null $encoding
     *
     * @return string
     */
    public static function upperCase(string $string, ?string $encoding = null): string {
        if (static::isMbstringLoaded()) {
            return mb_convert_case($string, MB_CASE_UPPER, $encoding ?? self::$encoding);
        }

        return strtoupper($string);
    }

    /**
     * Safely converts the given string to lowercase.
     *
     * @param string      $string
     * @param string|null $encoding
     *
     * @return string
     */
    public static function lowerCase(string $string, ?string $encoding = null): string {
        if (static::isMbstringLoaded()) {
            return mb_convert_case($string, MB_CASE_LOWER, $encoding ?? self::$encoding);
        }

        return strtolower($string);
    }

    /**
     * Safely converts the given string to title case.
     *
     * @param string      $string
     * @param string|null $encoding
     *
     * @return string
     */
    public static function upperWords(string $string, ?string $encoding = null): string {
        if (static::isMbstringLoaded()) {
            return mb_convert_case($string, MB_CASE_TITLE, $encoding ?? self::$encoding);
        }

        return ucwords($string);
    }


    public static function upperFirst(string $string, ?string $encoding = null): string {
        return ucfirst($string);
    }

    public static function lowerFirst(string $string, ?string $encoding = null): string {
        return lcfirst($string);
    }

    /**
     * Formats a string template with a given set of variables.
     *
     * @param string $format
     * @param array  $params
     *
     * @return string
     */
    public static function format(string $format, array $params): string {
        return vsprintf($format, $params);
    }

    /**
     * Safely gets the length of a string.
     *
     * @param string      $string
     * @param string|null $encoding
     *
     * @return int
     */
    public static function length(string $string, ?string $encoding = null): int {
        if (static::isMbstringLoaded()) {
            return mb_strlen($string, $encoding ?? self::$encoding);
        }

        return strlen($string);
    }

    /**
     * Checks if the length of the given string matches up or not.
     *
     * @param string      $string
     * @param string      $operator
     * @param int         $expectedLength
     * @param string|null $encoding
     *
     * @return bool
     */
    public static function isLength(
        string $string,
        string $operator,
        int $expectedLength,
        string $encoding = null
    ): bool {
        $length = self::length($string, $encoding);

        return version_compare((string)$length, (string)$expectedLength, $operator);
    }

    /**
     * Checks if a string contains only digits or not.
     *
     * @param string $text
     *
     * @return bool
     */
    public static function hasDigits(string $text): bool {
        return CtypeUtil::isDigit($text);
    }

    /**
     * Returns an array with each character from array.
     *
     * @param string $text
     *
     * @return array
     */
    public static function split(string $text): array {
        return str_split($text);
    }

    /**
     * Returns a text that contains only [a-z][0-9][-_] characters.
     *
     * @param string $text
     *
     * @return string
     */
    public static function plainText(?string $text): string {
        if (null === $text) {
            return '';
        }

        return RegexUtil::replace($text, '/[^a-z0-9-_]+/i', '-');
    }

    /**
     * @param string $text
     * @param string $startsWith
     *
     * @return bool
     */
    public static function startsWith(string $text, string $startsWith): bool {
        if (static::isMbstringLoaded()) {
            return mb_substr($text, 0, self::length($startsWith), 'UTF-8') === $startsWith;
        }

        return substr($text, 0, self::length($startsWith)) === $startsWith;
    }

    /**
     * @param string $text
     * @param string $endsWith
     *
     * @return bool
     */
    public static function endsWith(string $text, string $endsWith): bool {
        if (static::isMbstringLoaded()) {
            return mb_substr($text, -self::length($endsWith), null, 'UTF-8') === $endsWith;
        }

        return substr($text, -self::length($endsWith)) === $endsWith;
    }

    /**
     * Cuts a given text starting from a position and returns the text.
     *
     * @param string   $text
     * @param int|null $position
     *
     * @return string
     */
    public static function cut(string $text, int $position = 0): string {
        return substr($text, $position);
    }

    /**
     * Repeats a given string using given iterations.
     *
     * @param string $text
     * @param int    $times
     *
     * @return string
     */
    public static function repeat(string $text, int $times): string {
        return str_repeat($text, $times);
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public static function trim(string $text): string {
        return trim($text);
    }

    /**
     * @param string $text
     * @param int    $max
     *
     * @return string
     */
    public static function truncate(string $text, int $max): string {
        return substr($text, 0, $max);
    }

    /**
     * @param string $text
     * @param string $substring
     *
     * @return bool
     */
    public static function contains(string $text, string $substring): bool {
        return false !== strpos($text, $substring);
    }

    /**
     * @param string $text
     * @param array  $params
     *
     * @return string
     */
    public static function replace(string $text, array $params): string {
        return strtr($text, $params);
    }

    /**
     * @param string $bin
     *
     * @return string
     */
    public static function toHex(string $bin): string {
        return bin2hex($bin);
    }

    /**
     * @param array  $array
     * @param string $delimiter
     *
     * @return string
     */
    public static function fromArray(array $array, string $delimiter): string {
        return implode($delimiter, $array);
    }

    /**
     * @param string $value
     * @param string $pattern
     * @param bool   $sensitive
     *
     * @return bool
     */
    public static function regex(string $value, string $pattern, bool $sensitive = false): bool {
        $modifier = '';

        if ($sensitive) {
            $modifier = 'i';
        }

        return RegexUtil::match("/({$pattern})/{$modifier}", $value)['status'];
    }

    /**
     * @param string $text
     * @param int    $length
     * @param int    $direction
     *
     * @return string
     */
    public static function pad(string $text, int $length = 0, int $direction = STR_PAD_BOTH): string {
        return str_pad($text, $length, $direction);
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public static function escape(string $text): string {
        return htmlentities($text, ENT_QUOTES, 'UTF-8');
    }

    /**
     * @param string|null $text
     *
     * @return bool
     */
    public static function isEncrypted(?string $text): bool {
        if (null === $text) {
            return false;
        }

        return substr($text, 0, 3) === 'def';
    }

    /**
     * @param string[] $texts
     *
     * @return string
     */
    public static function concat(string ...$texts): string {
        $str = '';
        foreach ($texts as $text) {
            $str .= $text;
        }

        return $str;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isValid(string $text): bool {
        return is_string($text);
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isEmpty(string $text): bool {
        return self::isLength($text, '==', 0);
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public static function camelToKebab(string $text): string {
        return self::lowerCase(
            RegexUtil::replace(
                $text,
                '~(?<=\\w)([A-Z])~u',
                '-$1'
            )
        );
    }

    public function kebabToCamel(string $text): string {
        $text = self::replace($text, ['-' => '_']);

        return (new Inflector)->classify($text);
    }
}

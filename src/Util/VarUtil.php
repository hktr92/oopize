<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use function gettype;
use function is_null;
use function is_object;

/**
 * Class VarUtil
 * @package Oopize\Util
 * @since   0.1
 */
final class VarUtil {
    public const
        TYPE_STRING = 'string',
        TYPE_INT = 'int',
        TYPE_FLOAT = 'float',
        TYPE_BOOL = 'bool',
        TYPE_ARRAY = 'array';

    /**
     * @param mixed $var
     *
     * @return string
     */
    public static function getType($var): string {
        return gettype($var);
    }

    /**
     * calling empty() is not advised here as the target is to have nullable value in database (e.g. 'someCount' => 0;
     * empty(0) returns true in this case)
     *
     * @param mixed $var
     *
     * @return bool
     */
    public static function isNull($var): bool {
        return is_null($var)
            || '' == $var
            || 'null' == $var;
    }

    /**
     * @param $var
     *
     * @return bool
     */
    public static function isObject($var): bool {
        return is_object($var);
    }

    /**
     * @param mixed  $var
     * @param string $expectedType
     *
     * @return bool
     */
    public static function isTypeOf($var, string $expectedType) {
        return $expectedType === self::getType($var);
    }

    /**
     * @param mixed $var
     * @param bool  $nullable
     *
     * @return string|null
     */
    public static function castToString($var, bool $nullable = false): ?string {
        $cast = self::cast($var, self::TYPE_STRING);
        if ($nullable && StringUtil::isEmpty($cast)) {
            return null;
        }

        return $cast;
    }

    /**
     * @param mixed $var
     * @param bool  $nullable
     *
     * @return string|null
     */
    public static function castToArray($var, bool $nullable = false): ?string {
        $cast = self::cast($var, self::TYPE_ARRAY);
        if ($nullable && StringUtil::isEmpty($cast)) {
            return null;
        }

        return $cast;
    }

    /**
     * @param mixed  $var
     * @param string $type
     *
     * @return mixed
     */
    private static function cast($var, string $type) {
        switch ($type) {
            case self::TYPE_STRING:
                return (string)$var;
            case self::TYPE_INT:
                return (int)$var;
            case self::TYPE_FLOAT:
                return (float)$var;
            case self::TYPE_BOOL:
                return (bool)$var;
            case self::TYPE_ARRAY:
                return (array)$var;
            default:
                return $var;
        }
    }
}

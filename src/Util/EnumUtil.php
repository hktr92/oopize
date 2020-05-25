<?php
declare(strict_types=1);

namespace Oopize\Util;

use InvalidArgumentException;
use function in_array;

final class EnumUtil {
    private static $hotmap = [];

    /**
     * This is much more than a simple in_array wrapper.
     *
     * You must define a constant called ENUM in order to work.
     *
     * @param string $class
     * @param mixed  $value
     *
     * @return bool
     */
    public static function isValid(string $class, $value): bool {
        if (isset(self::$hotmap[$class])) {
            return self::$hotmap[$class];
        }

        if (false === ClassUtil::hasConstant($class, 'ENUM')) {
            throw new InvalidArgumentException(
                "Class '{$class}' must implement a constant 'ENUM' of type array in order to be used as enum type."
            );
        }

        $enumList = ClassUtil::getConstantValue($class, 'ENUM');
        if (false === ArrayUtil::isArray($enumList)) {
            throw new InvalidArgumentException(
                "Class '{$class}' must implement a constant 'ENUM' of type array in order to be used as enum type."
            );
        }

        return in_array($value, $enumList, true);
    }
}

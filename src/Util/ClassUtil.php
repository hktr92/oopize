<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use Doctrine\Common\Inflector\Inflector;
use function class_exists;

/**
 * Class ClassUtil
 * @package Oopize\Util
 * @since   0.1
 */
final class ClassUtil {
    /**
     * @param string $class
     *
     * @return bool
     */
    public static function exists(string $class): bool {
        return class_exists($class);
    }

    /**
     * @param object $class
     * @param string $targetClass
     *
     * @return bool
     */
    public static function isInstanceOf($class, string $targetClass): bool {
        if (false === self::exists($targetClass)) {
            return false;
        }

        return $class instanceof $targetClass;
    }

    /**
     * @param object $Entity
     * @param string $field
     *
     * @return mixed
     */
    public static function callObjectGetter($Entity, string $field) {
        return self::callGetter($Entity, self::getter($field));
    }

    /**
     * @param object $object
     * @param string $method
     *
     * @return mixed
     */
    public static function callGetter($object, string $method) {
        return FunctionUtil::call([$object, $method]);
    }

    /**
     * @param object $Entity
     * @param string $field
     * @param mixed  $value
     */
    public static function callObjectSetter($Entity, string $field, $value): void {
        self::callSetter($Entity, self::setter($field), $value);
    }

    /**
     * @param object $object
     * @param string $setter
     * @param mixed  $value
     */
    private static function callSetter($object, string $setter, $value) {
        FunctionUtil::call([$object, $setter], [$value]);
    }

    /**
     * @param object $Entity
     * @param string $field
     *
     * @return bool
     */
    public static function callObjectTester($Entity, string $field): bool {
        return self::callTester($Entity, self::tester($field));
    }

    /**
     * @param object $object
     * @param string $tester
     *
     * @return bool
     */
    private static function callTester($object, string $tester): bool {
        return FunctionUtil::call([$object, $tester]);
    }

    /**
     * @param string $column
     *
     * @return string
     */
    public static function classify(string $column): string {
        return Inflector::classify($column);
    }

    /**
     * @param string $column
     *
     * @return string
     */
    public static function setter(string $column): string {
        $classified = self::classify($column);

        return "set{$classified}";
    }

    /**
     * @param string $column
     *
     * @return string
     */
    public static function getter(string $column): string {
        $classified = self::classify($column);

        return "get{$classified}";
    }

    /**
     * @param string $column
     *
     * @return string
     */
    public static function tester(string $column): string {
        $classified = self::classify($column);

        return "is{$classified}";
    }
}

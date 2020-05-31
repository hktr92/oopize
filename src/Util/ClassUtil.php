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
use ReflectionClass;
use ReflectionException;
use function class_exists;
use function get_class;
use function is_object;
use function is_string;
use function property_exists;

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
     * @param $object
     *
     * @return string
     */
    public static function getName($object): string {
        return get_class($object);
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
     *
     * @throws ReflectionException
     */
    public static function callObjectSetter($Entity, string $field, $value): void {
        self::callSetter($Entity, self::setter($field), $value);
    }

    /**
     * @param object $object
     * @param string $setter
     * @param mixed  $value
     *
     * @throws ReflectionException
     */
    private static function callSetter($object, string $setter, $value) {
        if (false === self::hasMethod($object, $setter)) {
            return;
        }

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

    /**
     * @param object $instance
     * @param string $property
     *
     * @return bool
     */
    public static function hasProperty($instance, string $property): bool {
        return property_exists($instance, $property);
    }

    /**
     * @param object $instance
     * @param string $method
     *
     * @return bool
     * @throws ReflectionException
     */
    public static function hasMethod($instance, string $method): bool {
        return self::reflect($instance)->hasMethod($method);
    }

    public static function hasConstant($instanceOrClass, string $constant): bool {
        return self::getConstants($instanceOrClass)->getKeys()->contains($constant);
    }

    public static function getConstantValue($instanceOrClass, string $constant) {
        return self::getConstants($instanceOrClass)->get($constant);
    }

    /**
     * @param $instanceOrClass
     *
     * @return string
     */
    public static function getInstanceName($instanceOrClass): string {
        if (false === is_string($instanceOrClass)) {
            return self::getName($instanceOrClass);
        }

        return $instanceOrClass;
    }

    public static function getConstants($instanceOrClass) {
        try {
            $Reflection = self::reflect($instanceOrClass);

            return new ArrayUtil($Reflection->getConstants());
        } catch (ReflectionException $e) {
            return new ArrayUtil;
        }
    }

    /**
     * @param object $instance
     * @param string $property
     *
     * @return mixed
     * @throws ReflectionException
     *
     * @deprecated in favor of ClassUtil::getProperty()
     */
    public static function access($instance, string $property) {
        return self::getProperty($instance, $property);
    }

    /**
     * @param string $class
     * @param array  $args
     *
     * @return object|null
     *
     * @throws \ReflectionException
     */
    public static function makeInstance(string $class, array $args = []) {
        if (false === self::exists($class)) {
            return null;
        }

        $Class = self::reflect($class);

        if ($Class->isAbstract()) {
            return null;
        }

        if ($Class->hasMethod('__construct')) {
            $Constructor = $Class->getMethod('__construct');

            if (false === $Constructor->isPublic()) {
                return null;
            }
        }

        return $Class->newInstanceArgs($args);
    }

    /**
     * Tests if an instance or a class name is valid, via voting:
     * - if has namespace
     * - if exists
     *
     * @param $instanceOrClass
     *
     * @return bool
     */
    public static function isValid($instanceOrClass): bool {
        try {
            self::reflect($instanceOrClass);

            return true;
        } catch (ReflectionException $Exception) {
            return false;
        }
    }

    public static function isClass($instanceOrClass): bool {
        if (is_string($instanceOrClass)) {
            return class_exists($instanceOrClass);
        }

        return is_object($instanceOrClass);
    }

    /**
     * @param $instanceOrClass
     *
     * @return ReflectionClass
     * @throws ReflectionException
     */
    public static function reflect($instanceOrClass): ReflectionClass {
        return new ReflectionClass($instanceOrClass);
    }

    /**
     * Safely gets an instance property
     *
     * @param object $instance
     * @param string $property
     *
     * @return null|mixed
     * @throws ReflectionException
     */
    public static function getProperty($instance, string $property) {
        $refl = self::reflect($instance);

        if (false === $refl->hasProperty($property)) {
            return null;
        }

        $prop = $refl->getProperty($property);

        return $prop->isStatic()
            ? $refl->getStaticPropertyValue($property, null)
            : $prop->getValue($instance);
    }
}

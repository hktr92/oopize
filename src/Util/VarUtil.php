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

/**
 * Class VarUtil
 * @package Oopize\Util
 * @since   0.1
 */
final class VarUtil {
    /**
     * @param mixed $var
     *
     * @return string
     */
    public static function getType($var): string {
        return gettype($var);
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
}

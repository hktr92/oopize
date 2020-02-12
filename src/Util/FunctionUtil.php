<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use function call_user_func_array;
use function function_exists;

/**
 * Class FunctionUtil
 * @package Oopize
 * @since   0.1
 */
final class FunctionUtil {
    /**
     * @param mixed $callable
     * @param array $parameters
     *
     * @return mixed
     */
    public static function call($callable, array $parameters = []) {
        return call_user_func_array($callable, $parameters);
    }

    /**
     * @param string $function
     *
     * @return bool
     */
    public static function exists(string $function): bool {
        return function_exists($function);
    }
}

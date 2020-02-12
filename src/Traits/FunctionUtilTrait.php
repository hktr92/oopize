<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Traits;

use Oopize\Util\ClassUtil;
use Oopize\Util\FunctionUtil;

/**
 * Trait FunctionUtilTrait
 * @package Oopize\Traits
 * @since   0.1
 */
trait FunctionUtilTrait {
    /**
     * @param string $method
     * @param array  $params
     *
     * @return mixed
     */
    protected function call(string $method, array $params = []) {
        return FunctionUtil::call([$this, $method], $params);
    }

    /**
     * @param string $method
     * @param mixed  $value
     */
    protected function callSetter(string $method, $value) {
        ClassUtil::callObjectSetter($this, $method, $value);
    }

    /**
     * @param string $method
     *
     * @return mixed
     */
    protected function callGetter(string $method) {
        return ClassUtil::callObjectGetter($this, $method);
    }

    /**
     * @param string $method
     *
     * @return bool
     */
    protected function callTester(string $method): bool {
        return ClassUtil::callObjectTester($this, $method);
    }
}

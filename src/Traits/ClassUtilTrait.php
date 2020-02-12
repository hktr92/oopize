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

/**
 * Trait ClassUtilTrait
 * @package Oopize\Traits
 * @since   0.1
 */
trait ClassUtilTrait {
    /**
     * @param string $class
     *
     * @return bool
     */
    protected function isInstanceOf(string $class): bool {
        return ClassUtil::isInstanceOf($this, $class);
    }
}

<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use function is_dir;

/**
 * Class DirUtil
 * @package Oopize\Util
 * @since   0.2
 */
final class DirUtil {
    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isValid(string $path): bool {
        return is_dir($path);
    }
}

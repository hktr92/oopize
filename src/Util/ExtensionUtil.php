<?php
declare(strict_types=1);

namespace Oopize\Util;

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use function extension_loaded;
use function phpversion;

/**
 * Class ExtensionUtil
 * @package Oopize\Util
 * @since   0.1
 */
final class ExtensionUtil {
    /**
     * @param string $ext
     *
     * @return bool
     */
    public static function isLoaded(string $ext): bool {
        return extension_loaded($ext);
    }

    /**
     * @param string $ext
     *
     * @return string
     */
    public static function getVersion(string $ext): string {
        return phpversion($ext);
    }
}

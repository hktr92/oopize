<?php
declare(strict_types=1);

namespace Oopize\Util;

use function hexdec;

/**
 * Class HexUtil
 * @package Oopize\Util
 * @since   0.3
 */
final class HexUtil {
    /**
     * @param string $hex
     *
     * @return int
     */
    public static function toInt(string $hex): int {
        return hexdec($hex);
    }
}

<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use InvalidArgumentException;
use function number_format;
use function round;

/**
 * Class NumberFormat
 * @package Oopize\Util
 * @since   0.1
 */
final class NumberUtil {
    /**
     * @param int|float $seconds
     *
     * @return float
     */
    public static function toHours($seconds): float {
        if (0 === $seconds) {
            return (float)0;
        }

        return (float)($seconds / 3600);
    }

    /**
     * @param int|float $hours
     * @param int|float $minutes
     *
     * @return float
     */
    public static function toSeconds($hours, $minutes = 0): float {
        if (0 === $hours) {
            return (float)0;
        }

        $hoursInSeconds = $hours * 3600;

        if ($minutes > 0) {
            $hoursInSeconds += $minutes * 60;
        }

        return (float)$hoursInSeconds;
    }

    /**
     * @param int|float $number
     * @param int       $decimals
     * @param string    $decPoint
     * @param string    $thousandsSep
     *
     * @return string
     */
    public static function formatWithDecimals(
        $number,
        int $decimals = 2,
        string $decPoint = '.',
        string $thousandsSep = ','
    ): string {
        return number_format($number, $decimals, $decPoint, $thousandsSep);
    }

    /**
     * @param int|float $anyNumber
     *
     * @return float
     *
     * @throws InvalidArgumentException
     */
    public static function toFloat($anyNumber): float {
        if (false === CtypeUtil::isDigit($anyNumber)) {
            $type = VarUtil::getType($anyNumber);

            throw new InvalidArgumentException(
                "Provided parameter must be number (int, float, string with numbers), {$type} given."
            );
        }

        return (float)$anyNumber;
    }

    /**
     * @param int|float $number
     * @param int       $precision
     *
     * @return float
     */
    public static function round($number, int $precision = 2): float {
        return round($number, $precision);
    }
}

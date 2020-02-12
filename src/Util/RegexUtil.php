<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use function preg_match;
use function preg_replace;

/**
 * Class RegexUtil
 * @package Oopize\Util
 * @since   0.1
 */
final class RegexUtil {
    /**
     * @param string $source
     * @param string $regex
     * @param string $replacement
     *
     * @return string|null
     */
    public static function replace(string $source, string $regex, string $replacement): ?string {
        return preg_replace($regex, $replacement, $source);
    }

    /**
     * @param string $source
     * @param array  $rules
     *
     * @return string
     */
    public static function replaceAll(string $source, array $rules): string {
        $processed = $source;
        forEach ($rules as $regex => $replacement) {
            $processed = self::replace($source, $regex, $replacement);
        }

        return $processed;
    }

    /**
     * @param string $text
     * @param string $regex
     *
     * @return array
     */
    public static function match(string $text, string $regex): array {
        $matches     = [];
        $matchResult = preg_match($regex, $text, $matches);

        if (false === $matchResult) {
            return [];
        }

        return [
            'status'  => $matchResult === 1
                ? true
                : false,
            'matches' => $matches,
        ];
    }
}

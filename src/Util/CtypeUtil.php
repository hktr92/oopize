<?php
declare(strict_types=1);

namespace Oopize\Util;

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use function ctype_digit;

/**
 * Class CtypeUtil
 * @package Oopize\Util
 * @since   0.1
 */
final class CtypeUtil {
    /**
     * @param $text
     *
     * @return bool
     */
    public static function isDigit($text): bool {
        if (FunctionUtil::exists('ctype_digit')) {
            return ctype_digit($text);
        }

        return StringUtil::isValid($text)
            && false === StringUtil::isEmpty($text)
            && false === RegexUtil::match($text, '/[^0-9]/');
    }

}

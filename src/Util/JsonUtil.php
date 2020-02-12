<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use function json_decode;
use function json_encode;
use function json_last_error;
use function json_last_error_msg;
use const JSON_ERROR_NONE;

/**
 * Class JsonUtil
 * @package Oopize\Util
 * @since   0.1
 */
final class JsonUtil {
    /**
     * @param string $json
     * @param bool   $asObject
     *
     * @return mixed
     */
    public static function parse(string $json, bool $asObject = false) {
        return json_decode($json, $asObject);
    }

    /**
     * @param $json
     *
     * @return string
     */
    public static function stringify($json): string {
        return json_encode($json);
    }

    /**
     * @param $json
     *
     * @return bool
     */
    public static function isValid($json): bool {
        self::parse($json);

        return JSON_ERROR_NONE === self::getError()['code'];
    }

    /**
     * @return array
     */
    public static function getError(): array {
        return [
            'code'    => json_last_error(),
            'message' => json_last_error_msg(),
        ];
    }
}

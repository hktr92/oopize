<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use function constant;
use function file;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function unlink;

/**
 * Class FsUtil
 * @package Oopize\Util
 * @since   0.1
 */
final class FileUtil {
    const OPTS_APPEND = 'FILE_APPEND';

    /**
     * @param string $path
     *
     * @return false|string
     */
    public static function readContents(string $path): ?string {
        $contents = file_get_contents($path);

        return $contents
            ?: null;
    }

    /**
     * @param string $file
     *
     * @return ArrayUtil
     */
    public static function readLines(string $file): ArrayUtil {
        return new ArrayUtil(
            file($file)
                ?: []
        );
    }

    /**
     * @param string     $path
     * @param string     $contents
     * @param array|null $opts
     */
    public static function writeContents(string $path, string $contents, ?array $opts = []): void {
        $flags = 0;
        foreach ($opts as $opt => $value) {
            if ($opt === self::OPTS_APPEND && VarUtil::isTrue($value)) {
                $flags &= constant($opt);
            }
        }

        file_put_contents($path, $contents, $flags);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function exists(string $path): bool {
        return file_exists($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isValid(string $path): bool {
        return is_file($path);
    }

    /**
     * @param string $file
     */
    public static function remove(string $file): void {
        unlink($file);
    }
}

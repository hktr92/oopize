<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

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
     * @param string $path
     * @param string $contents
     */
    public static function writeContents(string $path, string $contents): void {
        file_put_contents($path, $contents);
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
     * @param string $file
     */
    public static function remove(string $file): void {
        unlink($file);
    }
}

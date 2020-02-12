<?php
declare(strict_types=1);

/**
 * @author hktr92
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oopize\Util;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function is_dir;
use function rmdir;

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

    /**
     * @param string $path
     * @param bool   $recursive
     */
    public static function remove(string $path, bool $recursive = true): void {
        if (false === $recursive) {
            rmdir($path);

            return;
        }

        foreach (self::getFiles($path) as $file) {
            if ($file->isDir()) {
                self::remove($file->getRealPath(), false);
            } else {
                FileUtil::remove($file->getRealPath());
            }
        }

        self::remove($path, false);
    }

    /**
     * @param string $path
     *
     * @return iterable
     */
    public static function getFiles(string $path): iterable {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $path,
                RecursiveDirectoryIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );
    }
}

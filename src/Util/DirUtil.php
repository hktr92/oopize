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
use function dirname;
use function is_dir;
use function rmdir;

/**
 * Class DirUtil
 * @package Oopize\Util
 * @since   0.2
 */
final class DirUtil {
    public const PERM_WRITABLE = 'writable';

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isValid(string $path): bool {
        return is_dir($path);
    }

    public static function getRealPath(string $path): ?string {
        return realpath($path)
            ?: null;
    }

    public static function getBaseDirectory(string $path, ?string $suffix = null): string {
        return basename($path, $suffix);
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

    /**
     * @param string $path
     *
     * @return string
     */
    public static function getDirectoryName(string $path): string {
        return dirname($path);
    }

    /**
     * TODO: handle more permissions. The idea is to have a safe method to create directories.
     * @see https://github.com/symfony/filesystem/blob/master/Filesystem.php#L89-L106 for inspiration
     *
     * @param string     $directory
     * @param array|null $opts
     *
     * @return bool
     */
    public static function create(string $directory, ?array $opts = []): bool {
        // basic permissions
        $dirmode = 0644;

        foreach ($opts as $option => $value) {
            if (self::PERM_WRITABLE === $option && VarUtil::isTrue($value)) {
                $dirmode = 0777;
            }
        }

        return mkdir($directory, $dirmode, true);
    }
}

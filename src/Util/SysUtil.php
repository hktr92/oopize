<?php
declare(strict_types=1);

namespace Oopize\Util;

use function chdir;
use function getcwd;

/**
 * Class SysUtil
 * @package Oopize\Util
 */
final class SysUtil {
    /**
     * @return string
     */
    public static function getCurrentWorkingDir(): string {
        return getcwd();
    }

    /**
     * @param string $newDirectory
     */
    public static function changeDirectory(string $newDirectory): void {
        chdir($newDirectory);
    }

    /**
     * @param $command
     *
     * @return array
     */
    public static function execute($command): array {
        $lastLine = exec($command, $output, $exitCode);

        return [
            'lastLine' => $lastLine,
            'output'   => $output,
            'exitCode' => $exitCode,
        ];
    }
}

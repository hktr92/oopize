<?php
declare(strict_types=1);

namespace Oopize\Util;

use function mb_internal_encoding;

final class Multibyte {
    public static function isSupported(): bool {
        return ExtensionUtil::isLoaded('mbstring');
    }

    public static function setEncoding(?string $encoding = 'UTF-8'): void {
        mb_internal_encoding($encoding);
    }
}

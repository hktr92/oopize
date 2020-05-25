<?php
declare(strict_types=1);

namespace Oopize\Util;

use function mb_internal_encoding;
use function mb_regex_encoding;

final class Multibyte {
    public static function isSupported(): bool {
        return ExtensionUtil::isLoaded('mbstring');
    }

    public static function setEncoding(?string $encoding = 'UTF-8'): void {
        mb_internal_encoding($encoding);
        mb_regex_encoding($encoding);
    }

    public const
        PASS = 'pass',
        WCHAR = 'wchar',
        BYTE2BE = 'byte2be',
        BYTE2LE = 'byte2le',
        BYTE4BE = 'byte4be',
        BYTE4LE = 'byte4le',
        BASE64 = 'BASE64',
        UUENCODE = 'UUENCODE',
        HTML_ENTITIES = 'HTML-ENTITIES',
        QUOTED_PRINTABLE = 'Quoted-Printable',
        SEVEN_BIT = '7bit',
        EIGHT_BIT = '8bit',
        UCS_4 = 'UCS-4',
        UCS_4BE = 'UCS-4BE',
        UCS_4LE = 'UCS-4LE',
        UCS_2 = 'UCS-2',
        UCS_2BE = 'UCS-2BE',
        UCS_2LE = 'UCS-2LE',
        UTF_32 = 'UTF-32',
        UTF_32BE = 'UTF-32BE',
        UTF_32LE = 'UTF-32LE',
        UTF_16 = 'UTF-16',
        UTF_16BE = 'UTF-16BE',
        UTF_16LE = 'UTF-16LE',
        UTF_8 = 'UTF-8',
        UTF_7 = 'UTF-7',
        UTF7_IMAP = 'UTF7-IMAP',
        ASCII = 'ASCII',
        EUC_JP = 'EUC-JP',
        SJIS = 'SJIS',
        EUCJP_WIN = 'eucJP-win',
        EUC_JP_2004 = 'EUC-JP-2004',
        SJIS_WIN = 'SJIS-win',
        SJIS_MOBILE_DOCOMO = 'SJIS-Mobile#DOCOMO',
        SJIS_MOBILE_KDDI = 'SJIS-Mobile#KDDI',
        SJIS_MOBILE_SOFTBANK = 'SJIS-Mobile#SOFTBANK',
        SJIS_MAC = 'SJIS-mac',
        SJIS_2004 = 'SJIS-2004',
        UTF_8_MOBILE_DOCOMO = 'UTF-8-Mobile#DOCOMO',
        UTF_8_MOBILE_KDDI_A = 'UTF-8-Mobile#KDDI-A',
        UTF_8_MOBILE_KDDI_B = 'UTF-8-Mobile#KDDI-B',
        UTF_8_MOBILE_SOFTBANK = 'UTF-8-Mobile#SOFTBANK',
        CP932 = 'CP932',
        CP51932 = 'CP51932',
        JIS = 'JIS',
        ISO_2022_JP = 'ISO-2022-JP',
        ISO_2022_JP_MS = 'ISO-2022-JP-MS',
        GB18030 = 'GB18030',
        WINDOWS_1252 = 'Windows-1252',
        WINDOWS_1254 = 'Windows-1254',
        ISO_8859_1 = 'ISO-8859-1',
        ISO_8859_2 = 'ISO-8859-2',
        ISO_8859_3 = 'ISO-8859-3',
        ISO_8859_4 = 'ISO-8859-4',
        ISO_8859_5 = 'ISO-8859-5',
        ISO_8859_6 = 'ISO-8859-6',
        ISO_8859_7 = 'ISO-8859-7',
        ISO_8859_8 = 'ISO-8859-8',
        ISO_8859_9 = 'ISO-8859-9',
        ISO_8859_10 = 'ISO-8859-10',
        ISO_8859_13 = 'ISO-8859-13',
        ISO_8859_14 = 'ISO-8859-14',
        ISO_8859_15 = 'ISO-8859-15',
        ISO_8859_16 = 'ISO-8859-16',
        EUC_CN = 'EUC-CN',
        CP936 = 'CP936',
        HZ = 'HZ',
        EUC_TW = 'EUC-TW',
        BIG_5 = 'BIG-5',
        CP950 = 'CP950',
        EUC_KR = 'EUC-KR',
        UHC = 'UHC',
        ISO_2022_KR = 'ISO-2022-KR',
        WINDOWS_1251 = 'Windows-1251',
        CP866 = 'CP866',
        KOI8_R = 'KOI8-R',
        KOI8_U = 'KOI8-U',
        ARMSCII_8 = 'ArmSCII-8',
        CP850 = 'CP850',
        JIS_MS = 'JIS-ms',
        ISO_2022_JP_2004 = 'ISO-2022-JP-2004',
        ISO_2022_JP_MOBILE_KDDI = 'ISO-2022-JP-MOBILE#KDDI',
        CP50220 = 'CP50220',
        CP50220RAW = 'CP50220raw',
        CP50221 = 'CP50221',
        CP50222 = 'CP50222';
}

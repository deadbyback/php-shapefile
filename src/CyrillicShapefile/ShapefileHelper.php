<?php

namespace CyrillicShapefile;

class ShapefileHelper
{
    /**
     * @return string[]
     */
    public static function getAvailableCharsets(): array
    {
        return [
            'ASCII',
            'UTF-8',
            'Windows-1251',
        ];
    }


    /**
     * @return string[]
     */
    public static function getAvailableForRepairCharsets(): array
    {
        return [
            'Windows-1251',
            'Windows-1252',
            'ISO-8859-1',
            'ISO-8859-5',
            'ASCII',
            'UTF-8',
        ];
    }


    /**
     * @param string $ret
     * @param string $originalCharset
     * @return false|string
     */
    public static function tryRepairStringCharset(string $ret, string $originalCharset)
    {
        $charsets = self::getAvailableForRepairCharsets();

        if (($key = array_search($originalCharset, $charsets)) !== false) {
            unset($charsets[$key]);
        }

        foreach ($charsets as $charset) {
            $newRet = @iconv($charset, 'UTF-8//TRANSLIT', $ret);

            if (!$newRet) {
                continue;
            }

            return $newRet;
        }
        
        return false;
    }
}

<?php

namespace RauweBieten\ZipCodes;

class ZipCodes
{
    public static function getData($countryCode) {
        $filePath =  __DIR__ . '/data/' . $countryCode . '.php';
        if (file_exists($filePath)) {
            /** @noinspection PhpIncludeInspection */
            return include $filePath;
        }
        throw new \RuntimeException("Country $countryCode not supported");
    }
}
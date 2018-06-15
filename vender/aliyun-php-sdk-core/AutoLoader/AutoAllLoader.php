<?php

class AutoAllLoader {
    private static $autoloadPathArray = array(
        "aliyun-php-sdk-core",
        "aliyun-php-sdk-core/Auth",
        "aliyun-php-sdk-core/Http",
        "aliyun-php-sdk-core/Profile",
        "aliyun-php-sdk-core/Regions",
        "aliyun-php-sdk-core/Exception"
    );

    public static function autoload($className) {
        foreach (self::$autoloadPathArray as $path) {
            $file = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $className . ".php";
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
            if (is_file($file)) {
                include_once $file;
                break;
            }
        }
    }

    public static function addAutoloadPath($path) {
        array_push(self::$autoloadPathArray, $path);
    }
}

spl_autoload_register("AutoAllLoader::autoload");

?>

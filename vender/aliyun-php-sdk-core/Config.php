<?php

include_once 'AutoLoader/AutoAllLoader.php';
include_once 'Regions/EndpointConfig.php';
//config sdk auto load path.
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-ecs");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-batchcompute");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-sts");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-push");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-ram");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-ubsms");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-ubsms-inner");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-green");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-dm");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-iot");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-jaq");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-cs");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-live");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-vpc");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-kms");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-rds");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-slb");
AutoAllLoader::addAutoloadPath("aliyun-php-sdk-cms");

define('ENABLE_HTTP_PROXY', FALSE);
define('HTTP_PROXY_IP', '127.0.0.1');
define('HTTP_PROXY_PORT', '8888');

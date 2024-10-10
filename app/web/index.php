<?php

// comment out the following two lines when deployed to production
use Symfony\Component\Dotenv\Dotenv;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__) . '/.env');

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();

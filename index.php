<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL^E_NOTICE);

if(!file_exists(__DIR__.'/config/db.php')) {
    header('Location: edusec-requirements.php');
    die;
}

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/config/web.php');
$app = new yii\web\Application($config);
$app->run();

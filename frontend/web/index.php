<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);

if (isset($_GET['t'])) {
	$name = 'smin_check_bke';
	setcookie($name, time(), time() + (86400 * 30), "/");
}
if ((isset($_COOKIE['smin_check_bke']) &&  $_COOKIE['smin_check_bke'])) {
} 
$debug = false;
if (isset($_COOKIE['smin_check_bke']) &&  $_COOKIE['smin_check_bke']) {
	$debug = true;
	defined('YII_DEBUG') or define('YII_DEBUG', $debug);
	defined('YII_ENV') or define('YII_ENV', 'dev'); // Khong duoc thay doi bien nay (minhbn)
} else {
	defined('YII_DEBUG') or define('YII_DEBUG', $debug);
	defined('YII_ENV') or define('YII_ENV', 'real'); // Khong duoc thay doi bien nay (minhbn)
}
//defined('YII_DEBUG') or define('YII_DEBUG', true);

require(__DIR__ . '/../../common/autoload/autoload.php');
require(__DIR__ . '/../../frontend/autoload/autoload.php');
require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');
$config = yii\helpers\ArrayHelper::merge(
	require(__DIR__ . '/../../common/config/main.php'),
	//    require(__DIR__ . '/../../common/config/main-local.php'),
	require(__DIR__ . '/../config/main.php'),
	require(__DIR__ . '/../config/main-local.php')
);

(new yii\web\Application($config))->run();

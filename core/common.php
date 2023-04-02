<?php
error_reporting(0);
define('IN_CRONLITE', true);
define('VERSION', '1001');
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');
define('SYS_KEY', 'authkey');

date_default_timezone_set("PRC");
$date = date("Y-m-d H:i:s");
session_start();

require ROOT.'config.php';

if(!defined('SQLITE') && (!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname']))//检测安装
{
header('Content-type:text/html;charset=utf-8');
echo '数据库出错';
exit();
}

include_once(SYSTEM_ROOT."db.class.php");
$DB=new DB($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname'],$dbconfig['port']);

$password_hash='!@#%!s!0';
include_once(SYSTEM_ROOT."function.php");
?>
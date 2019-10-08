<?php
// error reporting - all errors for development (ensure you have display_errors = On in your php.ini file)
error_reporting(E_ALL & ~E_NOTICE);
mb_internal_encoding('UTF-8');
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {ob_end_clean(); ob_start("ob_gzhandler");} else {ob_end_clean(); ob_start();}
set_time_limit(0);
session_start();
require_once(str_replace('include', '', dirname(__FILE__)).'classes/MysqliDb.php');

if($_SERVER['HTTP_HOST']=="localhost")
{
  $host = 'localhost';
  $user = 'root'; 
  $pass ='root';
  $db = 'db_demo';
} else {
  $host = 'localhost';
  $user = '';
  $pass = '';
  $db = '';
}
$db = new Mysqlidb($host, $user, $pass, $db);
$db->query('SET CHARACTER SET utf8');

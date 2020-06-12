<?php
session_start();
ini_set('display_errors', 0);
date_default_timezone_set("Asia/Pontianak");

defined('APPLICATION_DIR') || define('APPLICATION_DIR', __DIR__);
defined('APPLICATION_HOST') || define('APPLICATION_HOST', $_SERVER['HTTP_HOST']);

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/application/components/environmentHelper.php');
require_once(__DIR__ . '/application/components/Helper.php');
load_environment();
require_once(__DIR__ . '/config.php');

require_once(__DIR__ . '/application/bootstrap.php');
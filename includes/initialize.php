<?php
// Here we define the core paths. Define them as absolute paths to
// make sure that require works as expected.


// load config.php before this file.
// config.php is the only file which differs from one installation
// to another. That is why it's listed in .gitignore
// Also, this require uses a relative path. Therefore
// config.php and initialize.php must live in the same directory.
require('config.php');

// homepage embeded external content id
defined('HOMEPAGEEMBEDEDECID') ? null : define('HOMEPAGEEMBEDEDECID', 1);

// PROJ_ROOT is defined in config.php

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
// DS
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
// LIB_PATH
defined('LIB_PATH') ? null : define('LIB_PATH', PROJ_ROOT.DS.'includes');
// LOGS_DIR
defined('LOGS_PATH') ? null : define('LOGS_PATH', PROJ_ROOT.DS.'logs');
// WEB_DIR
defined('WEB_DIR') ? null : define('WEB_DIR', PROJ_ROOT.DS.'web');
// VENDOR_DIR
defined('VENDOR_DIR') ? null : define('VENDOR_DIR', PROJ_ROOT.DS.'vendor');


// load basic functions next so that everything after can use them
require(LIB_PATH.DS.'functions.php');
// load_mainclass() is the no_framework autoloader
spl_autoload_register('load_mainclass');
// Load Composer's autoloader
require(VENDOR_DIR.DS.'autoload.php');

// Initialize $database and its alias
$database = new MySQLDatabase();
$db =& $database;
// Initialize $session and $message
$session = new Session();
$message = $session->message();

// Define Stripe Keys
if (ENVIRONMENT == 'development') {
	$myStripePubKey = TESTSTRIPEPUB;
	$myStripeSecKey = TESTSTRIPESEC;
} elseif (ENVIRONMENT == 'production') {
	$myStripePubKey = LIVESTRIPEPUB;
	$myStripeSecKey = LIVESTRIPESEC;
} else {
	die('I do not know which environment I am in.');
}
// and set the API Key to $myStripeSecKey.
// But, $myStripePubKey will set in the HTML.
\Stripe\Stripe::setApiKey($myStripeSecKey);
?>

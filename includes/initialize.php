<?php
// Here we define the core paths. Define them as absolute paths to
// make sure that require_once works as expected. Also, we do as
// many includes as we can to avoid having them coded into our
// other scripts.


// DEFINE PATH CONSTANTS

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)

// DS
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);


// SITE_ROOT constant
defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']);
  // The btb course didn't use $_SERVER['DOCUMENT_ROOT']
  // however I'm using it so my app runs both in dev and productio
  // using the same initialize.php file.


// LIB_PATH
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');


// INCLUDE LIBRARY SCRIPTS

// load config file first
// config.php is the only file that siffers from one installation
// to another. That is why it's listed in .gitignore
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core classes and their objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'mysqldatabase.php');

// load model classes
require_once(LIB_PATH.DS.'user.php');

?>

<?php
///////
// Here we define the core paths. Define them as absolute paths to
// make sure that require_once works as expected. Also, we do as
// many includes as we can to avoid having them coded into our
// other scripts.
///////

// load config file first
// config.php is the only file that differs from one installation
// to another. That is why it's listed in .gitignore
// Also, this require_once uses a relative path. Therefore
// config.php and initialize.php must live in the same directory.
require_once('config.php');

///////
// DEFINE PATH CONSTANTS
///////

// PROJ_ROOT is defined in config.php

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
//
// DS
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

// LIB_PATH
defined('LIB_PATH') ? null : define('LIB_PATH', PROJ_ROOT.DS.'includes');

// LOGS_DIR
defined('LOGS_PATH') ? null : define('LOGS_PATH', PROJ_ROOT.DS.'logs');


///////
// INCLUDE LIBRARY SCRIPTS
///////

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core classes and their objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'mysqldatabase.php');
require_once(LIB_PATH.DS.'databaseobject.php');

// load model classes
require_once(LIB_PATH.DS.'user.php');
require_once(LIB_PATH.DS.'photograph.php');

?>

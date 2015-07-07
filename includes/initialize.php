<?php
///////
// Here we define the core paths. Define them as absolute paths to
// make sure that require works as expected. Also, we do as
// many includes as we can to avoid having them coded into our
// other scripts.
///////


// Order Matters

// load config file first
// config.php is the only file that differs from one installation
// to another. That is why it's listed in .gitignore
// Also, this require uses a relative path. Therefore
// config.php and initialize.php must live in the same directory.
require('config.php');

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

// WEB_DIR
defined('WEB_DIR') ? null : define('WEB_DIR', PROJ_ROOT.DS.'web');


///////
// INCLUDE LIBRARY SCRIPTS
///////

// load basic functions next so that everything after can use them
require(LIB_PATH.DS.'functions.php');

// load core classes and their objects
require(LIB_PATH.DS.'session.php');
require(LIB_PATH.DS.'mysqldatabase.php');
require(LIB_PATH.DS.'databaseobject.php');
require(LIB_PATH.DS.'pagination.php');

// load model classes
require(LIB_PATH.DS.'user.php');
require(LIB_PATH.DS.'photograph.php');
require(LIB_PATH.DS.'comment.php');
?>

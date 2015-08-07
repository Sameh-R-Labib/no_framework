<?php

function strip_zeros_from_date( $marked_string="" ) {
// This function is intended for removing the leading
// zero from dates.  For example  *07/*01/2011  will
// will become 7/1/2011. NOTE however that the date
// string must be pre-marked with astrices before the
// month and day.

  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

/////
// This function takes two arguments which are strings.
// The first is $action which is a short phrase describing
// the action being logged. The second is $message which
// is a sentence describing the action being logged.
// If fopen() is able to open the log.txt file, then log_action()
// will append a line to log.txt (a file located
// in the LOGS_PATH directory.) The $content of this log
// entry line is a timestamp then $action and $message.
// Otherwise (if fopen() fails) log_action() will echo
// "Could not open log file for writing."
/////
function log_action($action, $message="") {
  $logfile = LOGS_PATH.DS.'log.txt';
  //$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
    $content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    //if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}


function redirect_to( $location = NULL ) {
// This function takes a string which normally
// goes in a Location header. Then places it in
// a Location header. Then exits the script.
// Although the script has terminated, its output
// will be sent to the browser (including the
// Location header. Output buffering must be set
// to be on for this to work.
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}


function output_message($message="") {
// This function takes a string parameter
// and returns that string wrapped in
// an HTML p tag with class="message".
// However, if the string parameter is
// empty it will return an empty string
// without any p tag.
  if (!empty($message)) {
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}


/**
 * SPL autoloader for main classes
 * $class_name is the name of the class to load
 */
function load_mainclass($class_name)
{
  $file_name = LIB_PATH.DS.strtolower($class_name).'.php';
  if (is_readable($file_name)) {
    require($file_name);
  }
}



// This function gets called whenever php can't find
// a class definition.
//function __autoload($class_name) {
//  $class_name = strtolower($class_name);
//  $path = LIB_PATH.DS."{$class_name}.php";
//  if (file_exists($path)) {
//    require($path);
//  } else {
//    die("The file {$class_name}.php could not be found.");
//  }
//}

function include_layout_template($template="") {
  include(PROJ_ROOT.DS.'web'.DS.'helpme'.DS.'layouts'.DS.$template);
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}


public function size_as_text($size) {
  if($size < 1024) {
    return "{$size} bytes";
  } elseif($size < 1048576) {
    $size_kb = round($size/1024);
    return "{$size_kb} KB";
  } else {
    $size_mb = round($size/1048576, 1);
    return "{$size_mb} MB";
  }
}

?>

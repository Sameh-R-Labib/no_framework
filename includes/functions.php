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



// scroll down


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


// scroll down

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

// This function gets called whenever php can't find
// a class definition.
function __autoload($class_name) {
  $class_name = strtolower($class_name);
  $path = "../../includes/{$class_name}.php";
  if (file_exists($path)) {
    require_once($path);
  } else {
    die("The file {$class_name}.php could not be found.");
  }
}

?>

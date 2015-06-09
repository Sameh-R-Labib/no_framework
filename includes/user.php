<?php
require_once('MySQLDatabase.php');

class User {

  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;
  public $organization;
  public $role;

  // Returns a result-set containing all the users
  public static function find_all() {
    return self::find_by_sql("SELECT * FROM users");
  }

  // Returns an associative array record for a user
  public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM users WHERE id={$id} LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  // Returns a result-set for an sql query string
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }


  // Returns a User object based on a user record array
  private static function instantiate($record) {
    // Could check that $record exists and is an array

    // self instead of User()
    $object = new self;

    foreach($record as $attribute=>$value){
      if($object->has_attribute($attribute)) {
	// The statement below shows an example of a
        // variable variable
	$object->$attribute = $value;
      }
    }
    return $object;
  }

  // Returns boolean reflecting whether the
  // specified attribute string is actually
  // an attribute for this object/class.
  private function has_attribute($attribute) {
    // get_object_vars returns an associative array with all attributes
    // (incl. private ones!) as the keys and their current values as the value
    $object_vars = get_object_vars($this);
    // We don't care about the value, we just want to know if the key exists
    // Will return true or false
    return array_key_exists($attribute, $object_vars);
  }

}

?>

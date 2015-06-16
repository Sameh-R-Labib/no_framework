<?php
require_once(LIB_PATH.DS.'mysqldatabase.php');

class DatabaseObject {
  /////
  // Returns a result-set containing all the objects
  /////
  public static function find_all() {
    return static::find_by_sql("SELECT * FROM ".static::$table_name);
  }

  /////
  // Returns an associative array record for an object
  /////
  public static function find_by_id($id=0) {
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id={$id} LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  /////
  // Returns a result-set for an sql query string
  /////
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = static::instantiate($row);
    }
    return $object_array;
  }

  /////
  // Returns an object based on an object record array
  /////
  private static function instantiate($record) {
    // Could check that $record exists and is an array

    // But how to pass parameters to constructor?
    $object = new static;

    foreach($record as $attribute=>$value){
      if($object->has_attribute($attribute)) {
	// The statement below shows an example of a
        // variable variable
	$object->$attribute = $value;
      }
    }
    return $object;
  }

  /////
  // Returns boolean reflecting whether the
  // specified attribute string is actually
  // an attribute for this object/class.
  /////
  private function has_attribute($attribute) {
    // get_object_vars returns an associative array with all attributes
    // (incl. private ones!) as the keys and their current values as the value
    $object_vars = get_object_vars($this);
    // We don't care about the value, we just want to know if the key exists
    // Will return true or false
    return array_key_exists($attribute, $object_vars);
  }

  /////
  //
  /////
  protected function create() {
    global $database;
 
    // Don't forget your SQL syntax and good habits:
    // - INSERT INTO table (key, key) VALUES ('value', 'value')
    // - single-quotes around all values
    // - escape all values to prevent SQL injection
    $sql = "INSERT INTO ".self::$table_name." (";
    $sql .= "username, password, first_name, last_name";
    $sql .= ") VALUES ('";
    $sql .= $database->escape_value($this->username) ."', '";
    $sql .= $database->escape_value($this->password) ."', '";
    $sql .= $database->escape_value($this->first_name) ."', '";
    $sql .= $database->escape_value($this->last_name) ."')";

    if($database->query($sql)) {
      $this->id = $database->insert_id();
      return true;
    } else {
      return false;
    }
  }

  /////
  //
  /////
  protected function update() {
    global $database;

    // Don't forget your SQL syntax and good habits:
    // - UPDATE table SET key='value', key='value' WHERE condition
    // - single-quotes around all values
    // - escape all values to prevent SQL injection
    $sql = "UPDATE ".self::$table_name." SET ";
    $sql .= "username='". $database->escape_value($this->username) ."', ";
    $sql .= "password='". $database->escape_value($this->password) ."', ";
    $sql .= "first_name='". $database->escape_value($this->first_name) ."', ";
    $sql .= "last_name='". $database->escape_value($this->last_name) ."' ";
    $sql .= "WHERE id=". $database->escape_value($this->id);

    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }


  /////
  //
  /////
  public function save() {
    // A new record won't have an id yet.
    return isset($this->id) ? $this->update() : $this->create();
  }


  /////
  //
  /////
  public function delete() {
    global $database;

    // Don't forget your SQL syntax and good habits:
    // - DELETE FROM table WHERE condition LIMIT 1
    // - escape all values to prevent SQL injection
    // - use LIMIT 1
    $sql = "DELETE FROM ".self::$table_name." ";
    $sql .= "WHERE id=". $database->escape_value($this->id);
    $sql .= " LIMIT 1";

    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

}

?>

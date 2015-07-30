<?php

class DatabaseObject {
	
	
	
	// Methods (a.k.a Functions)
	
	/* Termanology:
	 * object == objectified record
	 * record == arrayified record
	 * array == array of records
	 * field == static::$db_fields $field
	 */
	
  /***
	 * Give me an array of all the objects.
   ***/
  public static function find_all() {
    return static::find_by_sql("SELECT * FROM ".static::$table_name);
  }

  /***
   * Give me an object for this id.
   ***/
  public static function find_by_id($id=0) {
    global $database;
		
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name."
			WHERE id=".$database->escape_value($id)." LIMIT 1");
		
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  /***
	 * Give me an array of objects for this sql.
   ***/
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = static::instantiate($row);
    }
    return $object_array;
  }

  /***
   * Objectify this record.
   ***/
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

  /***
	 * Is this a field.
   ***/
  private function has_attribute($attribute) {
    // We don't care about the value, we just want to know if the key exists
    // Will return true or false
    return array_key_exists($attribute, $this->attributes());
  }

  /***
	 * Extract a record from this object.
   ***/
  protected function attributes() { 
    $attributes = [];
    foreach (static::$db_fields as $field) {
      if (property_exists($this, $field)) {
        $attributes[$field] = $this->$field;
      }
    }
    return $attributes;
  }

  /***
	 * Gets a db-escaped record from this object.
   ***/
  protected function sanitized_attributes() {
		global $database;
		
    $clean_attributes = array();

    // sanitize the values before submitting
    // Note: does not alter the actual value of each attribute
    foreach($this->attributes() as $key => $value){
      $clean_attributes[$key] = $database->escape_value($value);
    }
    return $clean_attributes;
  }

  /***
   * Inserts this object into db table.
   ***/
  protected function create() {
    global $database;
 
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO ".static::$table_name." (";
    $sql .= join(", ", array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";

    if($database->query($sql)) {
      $this->id = $database->insert_id();
      return true;
    } else {
      return false;
    }
  }

  /***
   * Updates the db record using this object's attributes.
   ***/
  protected function update() {
    global $database;

    $attributes = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }
    $sql = "UPDATE ".static::$table_name." SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE id=". $database->escape_value($this->id);

    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

  /***
   * Save what this object has in the database.
	 * Good if unsure whether to update or create.
   ***/
  public function save() {
    // A new record won't have an id yet.
    return isset($this->id) ? $this->update() : $this->create();
  }

  /***
   * Delete the db record for this object.
	 * Succeeds if this object exists in the db.
   ***/
  public function delete() {
    global $database;

    $sql = "DELETE FROM ".static::$table_name." ";
    $sql .= "WHERE id=". $database->escape_value($this->id);
    $sql .= " LIMIT 1";

    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

  /***
	 * How many records in db?
   ***/
  public static function count_all() {
    global $database;
    $sql = "SELECT COUNT(*) FROM ".static::$table_name;
    $result_set = $database->query($sql);
    $row = $database->fetch_array($result_set);
    return array_shift($row);
  }
}
?>

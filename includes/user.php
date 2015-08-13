<?php

class User extends DatabaseObject {

  protected static $table_name="users";
  protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'organization', 'role');
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;
  public $organization;
  public $role;


  /**
   * Returns the full name or an empty string
   */
  public function full_name() {
    if(isset($this->first_name) && isset($this->last_name)) {
      return $this->first_name . " " . $this->last_name;
    } else {
      return "";
    }
  }


  /**
   * Search for user then return user object if found. Otherwise, return false.
   */
  public static function authenticate($username="", $password="") {
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);

    $sql  = "SELECT * FROM users ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND password = '{$password}' ";
    $sql .= "LIMIT 1";
    $result_array = static::find_by_sql($sql);
    return !empty($result_array) ? array_shift($result_array) : false;
  }

}

?>

<?php

class MySQLDatabase {

  private $connection;    // php object which represents the connection to a MySQL Server


  /**
   * Sets $connection for this object
   */
  function __construct() {
    $this->open_connection();
  }


  /**
   * Sets $connection for this object
   */
  public function open_connection() {
    $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if(mysqli_connect_errno()) {
      die("Database connection failed: " .
           mysqli_connect_error() .
           " (" . mysqli_connect_errno() . ")"
      );
    }
  }


  /**
   * Unsets $connection
   */
  public function close_connection() {
    if(isset($this->connection)) {
      mysqli_close($this->connection);
      unset($this->connection);
    }
  }


  /**
   * Return a result set for $sql or die.
   * A result set is a PHP object which contains the results of a query.
   */
  public function query($sql) {
    $result = mysqli_query($this->connection, $sql);
    $this->confirm_query($result);
    return $result;
  }


  /**
   * Kill the script if False is the result of th query.
   */
  private function confirm_query($result) {
  	if (!$result) {
  		die("Database query failed.");
  	}
  }


  /**
   * Returns a db escaped version of $string.
   */
  public function escape_value($string) {
    $escaped_string = mysqli_real_escape_string($this->connection, $string);
    return $escaped_string;
  }

  // "database neutral" functions


  /**
   * Returns as an array one row of a result set object.
   */
  public function fetch_array($result_set) {
    return mysqli_fetch_array($result_set);
  }


  /**
   * Returns the number of rows in $result_set
   */
  public function num_rows($result_set) {
    return mysqli_num_rows($result_set);
  }


  /**
   * Returns the last id inserted over the current db connection
   */
  public function insert_id() {
     return mysqli_insert_id($this->connection);
  }


  /**
   * Returns the number of rows affected by the last query run on this connection.
   */
  public function affected_rows() {
    return mysqli_affected_rows($this->connection);
  }

}

?>

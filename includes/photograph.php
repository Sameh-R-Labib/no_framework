<?php
require_once(LIB_PATH.DS.'mysqldatabase.php');

class Photograph extends DatabaseObject {
	
  protected static $table_name="photographs";
  protected static $db_fields=array('id', 'filename', 'type', 'size', 'caption');
  public $id;
  public $filename;
  public $type;
  public $size;
  public $caption;
	
}

?>
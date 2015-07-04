<?php
require_once(LIB_PATH.DS.'mysqldatabase.php');

class Comment extends DatabaseObject {

  protected static $table_name="comments";
  protected static $db_fields=array('id', 'photograph_id', 'created', 'author', 'body');

  public $id;
  public $photograph_id;
  public $created;
  public $author;
  public $body;

  // "new" is a reserved word so we use "make" (or "build")
  public static function make($photo_id, $author="Anonymous", $body="") {
    if(!empty($photo_id) && !empty($author) && !empty($body)) {
      $comment = new Comment();
      $comment->photograph_id = (int)$photo_id;
      $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
      $comment->author = $author;
      $comment->body = $body;
      return $comment;
    } else {
      return false;
    }
  }

  public static function find_comments_on($photo_id=0) {
    global $database;
    $sql = "SELECT * FROM " . static::$table_name;
    $sql .= " WHERE photograph_id=" .$database->escape_value($photo_id);
    $sql .= " ORDER BY created ASC";
    return static::find_by_sql($sql);
  }

}

?>

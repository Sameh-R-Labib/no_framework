<?php

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
    $sql .= " WHERE `photograph_id`=" .$database->escape_value($photo_id);
    $sql .= " ORDER BY created ASC";
    return static::find_by_sql($sql);
  }
  
  /**
   * Quantity of comments on a particular photograph.
   */
  public static function quantity($photograph_id=0) {
    global $database;
    $sql = "SELECT COUNT(*) FROM ".static::$table_name;
    $sql .= " WHERE photograph_id=".$database->escape_value($photograph_id);
    return static::find_by_sql($sql);
  }


  public function try_to_send_notification() {
    $mail = new PHPMailer;
    $mail->From     = 'superuser@buscompanyx.com';
    $mail->FromName = 'BusCompanyX.com App';
    $mail->addAddress('superuser@buscompanyx.com', 'Sameh R. Labib');
    $mail->Subject  = 'New Photo Gallery Comment';

    $created = datetime_to_text($this->created);
    $mail->Body     =<<<EMAILBODY

A new comment has been received in the Photo Gallery.

   At {$created}, {$this->author} wrote:

{$this->body}

EMAILBODY;

    return $mail->send();
  }
}
?>

<?php

class CommentOnVideo extends DatabaseObject {

	protected static $table_name="commentonvideo";
	protected static $db_fields=['id', 'video_id', 'author', 'author_email', 'body',
	'visible_comment', 'current_time'];
	
	public $id;
  public $video_id;
	public $author;
	public $author_email;
	public $body;
	public $visible_comment;
	public $current_time;


  /***
	 * Instantiate CommentOnVideo object based these parameters. make()
	 * does NOT handle id because make() is a custom instantiate().
	 ***/
  public static function make($video_id, $author='', $author_email='', $body='',	$visible_comment=0) {
		
    if (!empty($body) && !empty($author)) {
      $comment = new static();

      $comment->video_id        = $video_id;
      $comment->author          = $author;
      $comment->author_email    = $author_email;
			$comment->body            = $body;
			$comment->current_time    = strftime("%Y-%m-%d %H:%M:%S", time());
			$comment->visible_comment = $visible_comment;

      return $comment;
    } else {
			return false;
    }
  }


	/**
	 * Uses foreign key id rather than class id.
	 * Finds comments on a video.
	 */
  public static function find_comments_on($video_id=0) {
    global $database;
    $sql = "SELECT * FROM ".static::$table_name;
    $sql .= " WHERE video_id=".$database->escape_value($video_id);
    $sql .= " ORDER BY current_time DESC";
    return static::find_by_sql($sql);
  }
  
  
  /**
   * Finds the visible comments for a video.
   */
  public static function find_visible_comments_on($video_id=0) {
    global $database;
    $sql = "SELECT * FROM ".static::$table_name;
    $sql .= " WHERE `video_id`=".$database->escape_value($video_id);
    $sql .= " AND `visible_comment`=1";
    $sql .= " ORDER BY `current_time` DESC";
    return static::find_by_sql($sql);
  }

  
  /**
   * Quantity of comments on a particular video.
   */
  public static function quantity($video_id=0) {
    global $database;
    $sql = "SELECT COUNT(*) FROM ".static::$table_name;
    $sql .= " WHERE `video_id`=".$database->escape_value($video_id);
    
    $result_set = $database->query($sql);
    $result_array = $database->fetch_array($result_set);
    return !empty($result_array) ? array_shift($result_array) : false;
  }
  

	/**
	 * Sends an email to superuser@buscompanyx.com informing Sameh that a
	 * new video comment was made. Includes comment time, author and body.
	 */
  public function try_to_send_notification() {
    $mail = new PHPMailer;
    $mail->From     = 'superuser@buscompanyx.com';
    $mail->FromName = 'BusCompanyX.com App';
    $mail->addAddress('superuser@buscompanyx.com', 'Sameh R. Labib');
    $mail->Subject  = 'New video comment';

    $created = datetime_to_text($this->current_time);
    $mail->Body     =<<<EMAILBODY

A new comment has been received on a video at {$created} (EST time), {$this->author} wrote:

{$this->body}

Sameh needs to make this comment visible (or not.)

EMAILBODY;

    return $mail->send();
  }

}
?>
<?php

class EmbedXternal extends DatabaseObject {
	
	protected static $table_name="embedxternal";
	protected static $db_fields=['id', 'caption', 'embed_code', 'visible',
		'author', 'author_email', 'route_for_page', 'time_created'];
	public $id;
	public $caption;
	public $embed_code;
	public $visible;
	public $author;
	public $author_email;
	public $route_for_page; // Title for the video.
	public $time_created;
	
	
	/***
	 * Get an enumerated array of Comment objects.
	 ***/
  public function comments() {
    return CommentOnVideo::find_comments_on($this->id);
  }
  
  /**
   * Get an array of visible comments for this EmbedXternal object.
   */
  public function visible_comments() {
    return CommentOnVideo::find_visible_comments_on($this->id);
  }

  /***
	 * How many visible records?
   ***/
  public static function count_of_visible_videos() {
    global $database;
    $sql = "SELECT COUNT(*) FROM ".self::$table_name;
    $sql .= " WHERE `visible`=1";
    $result_set = $database->query($sql);
    $row = $database->fetch_array($result_set);
    return array_shift($row);
  }
  
  /**
   * Count of comments for this EmbedXternal.
   */
  public function comment_count() {
    return CommentOnVideo::quantity($this->id);
  }
	
  /***
	 * Instantiate an EmbedXternal. make() does NOT handle id because make() is
	 * a custom version of instantiate().
	 ***/
  public static function make($caption='', $embed_code='', $visible=0, $author='', $author_email='', $route_for_page='') {

    if (!empty($embed_code)) {
      $eEC = new self();
			// Attribute values: assigned all but id
      $eEC->caption = $caption;
      $eEC->embed_code = $embed_code;
			$eEC->visible = $visible;
			$eEC->time_created = strftime("%Y-%m-%d %H:%M:%S", time());
			$eEC->author = $author;
			$eEC->author_email = $author_email;
			$eEC->route_for_page = $route_for_page;

      return $eEC;
    } else {
			return false;
    }
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
    $mail->Subject  = 'New video submitted';

    $created = datetime_to_text($this->time_created);
    $mail->Body     =<<<EMAILBODY

A new video has been submitted at {$created} (EST time,) by {$this->author} {$this->author_email}

{$this->embed_code}

Sameh needs to make this video visible (or not.)

EMAILBODY;

    return $mail->send();
  }

}

?>
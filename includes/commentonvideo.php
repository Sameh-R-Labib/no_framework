<?php

class CommentOnVideo extends DatabaseObject {

	protected static $table_name="commentonvideo";
	protected static $db_fields=['id', 'author', 'author_email', 'body',
	'visible_comment', 'current_time'];
	
	public $id;
	public $author;
	public $author_email;
	public $body;
	public $visible_comment;
	public $current_time;

  /***
	 * Instantiate CommentOnVideo object based these parameters. make()
	 * does NOT handle id because make() is a custom instantiate().
	 ***/
  public static function make($author='', $author_email='', $body='',
	$visible_comment=0) {
		
    if (!empty($body) && !empty($author)) {
      $cOV = new self();

      $cOV->author = $author;
      $cOV->author_email = $author_email;
			$cOV->body = $body;
			$cOV->current_time = strftime("%Y-%m-%d %H:%M:%S", time());
			$cOV->visible_comment = $visible_comment;

      return $cOV;
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
    $sql .= " WHERE photograph_id=".$database->escape_value($video_id);
    $sql .= " ORDER BY current_time ASC";
    return static::find_by_sql($sql);
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

A new comment has been received on a video.

At {$created}, {$this->author} (EST time) wrote:

{$this->body}

Sameh needs to make it visible (or not.)

EMAILBODY;

    return $mail->send();
  }
	
	
	
	// FUNCTIONS INHERITED FROM DATABASEOBJECT
	
	/* Termanology:
	 * object == objectified record
	 * record == arrayified record
	 * array == array of records
	 * field == static::$db_fields $field
	 */
	
  /***
	 * Give me an array of all the objects.
   ***/
	// public static function find_all()
	
  /***
   * Give me an object for this id.
   ***/
  // public static function find_by_id($id=0)

  /***
	 * Give me an array of objects for this sql.
   ***/
  // public static function find_by_sql($sql="")
	
  /***
   * Objectify this record.
   ***/
  // private static function instantiate($record)
	
  /***
	 * Is this a field.
   ***/
  // private function has_attribute($attribute)

  /***
   * Inserts this object into db table.
   ***/
  // protected function create()
	
  /***
   * Updates the db record using this object's attributes.
   ***/
  // protected function update()
	
  /***
   * Save what this object has in the database.
	 * Good if unsure whether to update or create.
   ***/
  // public function save()
	
  /***
   * Delete the db record for this object.
	 * Succeeds if this object exists in the db.
   ***/
  // public function delete()
	
  /***
	 * Extract a record from this object.
   ***/
  // protected function attributes()
	
  /***
	 * Gets a db-escaped record from this object.
   ***/
  // protected function sanitized_attributes()
	
  /***
	 * How many records in db?
   ***/
  // public static function count_all()

}
?>
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
	public $route_for_page;
	public $time_created;
	
	
	// destroy()
	
	/***
	 * Get an enumerated array of Comment objects.
	 ***/
  public function comments() {
    return Comment::find_comments_on($this->id);
  }
	
  /***
	 * Instantiate an EmbedXternal
	 * NOTE: make() does NOT handle id AT ALL because make() is
	 *       just a custom version of instantiate().
	 ***/
  public static function make($caption='', $embed_code='', $visible=0,
		$author='', $author_email='', $route_for_page='') {
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
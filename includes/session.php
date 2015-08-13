<?php
/**
 * A class to help work with PHP Sessions - primarily to manage logging users in and out.
 * A User class must exist.
 */ 

class Session {
	
  private $logged_in=false;
  Private $user_id;
  Private $message;
  Private $visible_videos_page_number=0; // Should be set to the visible_videos_page_number the user is on. 0 means it's not set.


  /**
   * Dual purpose method. Depending on whether or not it is passed an argument.
   * When there is an argument message() will set $_SESSION['message'] to the argument.
   * When there is NOT an argument message() returns $this->message.
   */
  public function message($msg="") {
    if (!empty($msg)) {
      $_SESSION['message'] = $msg;
    } else {
      return $this->message;
    }
  }


  /**
   * Dual purpose method.
   *
   * 0 is not a page number.
   * If passed a page number then store the current page number for the script
   * called visible_video.php in the PHP Session.
   * If not passed a page number then return the visible_videos_page_number stored in this session object.
   */
  public function visible_videos_page_number($visible_videos_page_number=0) {
    if ($visible_videos_page_number) {
      $_SESSION['visible_videos_page_number'] = $visible_videos_page_number;
    } else {
      return $this->visible_videos_page_number;
    }
  }


  /**
   * 1. Retrieves session data and establishes session for this script based on the cookie or starts a new session.
   * 2. Primes the session object.
   * 3. Takes specified actions based on whether or not user is logged in.
   */
  function __construct() {
    session_start();
    $this->get_message_from_session();
    $this->get_login_status_from_session();
    if($this->logged_in) {
      // actions to take right away if user is logged in
    } else {
      // actions to take right away if user is not logged in
    }
  }

  /**
   * Is the user logged in per this object.
   */
  public function is_logged_in() {
    return $this->logged_in;
  }


  /**
   * If argument is a user object then user is logged in;
   * So, let the session and this session object know he/she is logged in.
   */
  public function login($user) { // $user is User object or false.
    if($user){
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->logged_in = true;
    }
  }


  /**
   * Mark the user as logged out in both the session and the session object.
   */
  public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->logged_in = false;
  }

  
  /**
   * Simply the fact that isset($_SESSION['user_id']) means the user is logged in. And if that is
   * the case then appropriately set the session objects attributes.
   */
  private function get_login_status_from_session() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }


  /**
   * Retrieves the session message and assigns it to the message attribute if there is a session message.
   * And in that case it will also wipe the message from the session. On the other hand if there is
   * NOT a session message then it assigns an empty string to the message attribute
   */
  private function get_message_from_session() {
    if(isset($_SESSION['message'])) {
      $this->message = $_SESSION['message'];
      unset($_SESSION['message']);
    } else {
      $this->message = "";
    }
  }

}

?>

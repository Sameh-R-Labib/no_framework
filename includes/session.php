<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

class Session {
	
  private $logged_in=false;
  public $user_id;

  // 1. retrieves session data and establishes session
  //    for this script based on the cookie
  //    or starts a new session
  // 2. primes the session object
  // 3. takes specified actions based on whether
  //    or not user is logged in
  function __construct() {
    session_start();
    $this->check_login();
    if($this->logged_in) {
      // actions to take right away if user is logged in
    } else {
      // actions to take right away if user is not logged in
    }
  }
	
  public function is_logged_in() {
    return $this->logged_in;
  }

  // Search Users table for user and
  // establish markers in both the session
  // object and the session itself if the user
  // was found.
  public function login($user) {
    // database should find user based on username/password
    if($user){
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->logged_in = true;
    }
  }

  // Mark the user as logged out in both
  // the session and the session object.
  public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->logged_in = false;
  }
  // Simply the fact that isset($_SESSION['user_id'])
  // means the user is logged in. And if that is
  // the case then appropriately set the session
  // objects attributes.
  private function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }
}

$session = new Session();
?>

<?php
/**
 * Delete & redirect.
 */

require("../../../includes/initialize.php");

// Kick back if not logged in as an admin
if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

// Kick back if no video id was specified
if(empty($_GET['id'])) {
 	$session->message("No video ID was specified in your page request.");
  redirect_to('../index.php');
}

$video = EmbedXternal::find_by_id($_GET['id']);

// Kick back if video not found in database.
if(!$video) {
 	$session->message("The video you've specified could not be found.");
  redirect_to('../index.php');
}

// Destroy record for video
if($video->destroy()) {
	// Video was destroyed
	$session->message("The video ".$video->route_for_page." was deleted.");
	redirect_to('list_videos.php');
} else {
	// Video was not destroyed
	$session->message("The video embed code could not be deleted.");
	redirect_to('list_videos.php');
}

if(isset($database)) { $database->close_connection(); }

?>
<?php
/**
 * This script INITIALLY runs when it is called with a comment id in the query string
 * of a GET request. Any other time this script runs it will be in response to a POST
 * request w/o a query string.
 * 
 * When it's a GET the comment will be retrieved and used to pre-populate a form.
 * When it's a POST the comment will be updated.
 */


// INCLUDE INITIALIZE AND KICK OUT IF NOT LOGGED IN
require("../../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }

// Am I responding to a POST request?
// If yes (which is what this block takes care of)
// then update the db using data from $_POST
if (isset($_POST['submit'])) {

	// EXTRACT DATA FROM $_POST
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	} else {
		$session->message('Something went wrong: Missing comment id.');
		redirect_to("update_commentonvideo.php");
	}
  if (isset($_POST['video_id'])) {
    $video_id = $_POST['video_id'];
  } else {
		$session->message('Something went wrong: Missing video id.');
		redirect_to("update_commentonvideo.php?id=".$id);
  }
	// current_time will be reset by make() so there is no sense
	// dealing with it at all in this script
	if (isset($_POST['author'])) {
		$author = trim($_POST['author']);
	} else {
		$author = '';
	}
	if (isset($_POST['author_email'])) {
		$author_email = trim($_POST['author_email']);
	} else {
		$author_email = '';
	}
	if (isset($_POST['body'])) {
		$body = trim($_POST['body']);
	} else {
		$body = '';
	}
	if (isset($_POST['visible_comment']) && $_POST['visible_comment'] == '1') {
		$visible_comment = 1;
	} else {
		$visible_comment = 0;
	}
  
	// INSTANTIATE A CommentOnVideo OBJECT
	$comment = CommentOnVideo::make($video_id, $author, $author_email, $body, $visible_comment);
	if (!$comment) {
		$session->message('Unable to instantiate the CommentOnVideo object.');
		redirect_to("update_commentonvideo.php?id=".$id);
	}

	// ASSIGN THE OBJECT ITS ORIGINAL ID
	// The reason we are just taking this step now is that make() does not
	// assign a value for id. Its just part of the code design.
	$comment->id = $id;
  
	// UPDATE THAT OBJECT
	if ($comment->update()) {
		$session->message("The CommentOnVideo was updated in the database.");
		redirect_to("update_commentonvideo.php?id=".$id);
	} else {
		$session->message("Unable to update the CommentOnVideo in the database.");
		redirect_to("update_commentonvideo.php?id=".$id);
	}
}

// Am I responding to a GET request?
// If Yes then read the data from the database
// so I can use it to pre-fill the form fields.
if(!empty($_GET['id'] && is_numeric($_GET['id']))) {
	// Then assume it's a GET request
	
	$comment = CommentOnVideo::find_by_id($_GET['id']);
  if(!$comment) {
    $session->message("The CommentOnVideo could not be retrieved from database.");
    redirect_to('comments_on_video.php?id='.$_GET['id']);
  }
	
	// Copy the attribs to vars.
	$attributes = $comment->attributes();
	extract($attributes);
} else {
  $session->message("You are NOT supposed to access this page directly.");
  redirect_to('index.php');
}

// SHOW TOP OF THE PAGE
include_layout_template('admin_header.php');
?>

<a href="index.php">&laquo; Back</a><br /><br />

<h2>Update This CommentOnVideo Record</h2>

<?php
// SHOW MESSAGE
echo output_message($message);

// SHOW FORM
if($visible) {
	$checkbox = '<input type="checkbox" name="visible" value="1" checked="checked" />';
} else {
	$checkbox = '<input type="checkbox" name="visible" value="1" />';
}
?>

<form action="update_commentonvideo.php" method="post">
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="hidden" name="video_id" value="<?php echo $video_id; ?>" />
  <table>
    <tr>
      <td>Author:</td>
      <td>
        <input type="text" name="author" maxlength="39" value="<?php echo $author; ?>" />
      </td>
    </tr>
    <tr>
      <td>Author Email:</td>
      <td>
        <input type="text" name="author_email" maxlength="79" value="<?php echo $author_email; ?>" />
      </td>
    </tr>
		<tr>
			<td>Visible</td>
			<td><?php echo $checkbox; ?></td>
		</tr>
		<tr>
			<td>Comment can have &lt;a&gt;&lt;strong&gt;&lt;em&gt;&lt;p&gt;</td>
			<td><textarea name="body" maxlength="3500" cols="70" rows="2"><?php echo $body; ?></textarea></td>
		</tr>
    <tr>
      <td colspan="2"><input type="submit" name="submit" value="Go" /></td>
    </tr>
  </table>
</form>

<?php
// SHOW BOTTOM OF THE PAGE
include_layout_template('admin_footer.php');
?>
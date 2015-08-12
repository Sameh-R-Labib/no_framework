<?php
/**
 * Enables a public user to:
 * 1. View video w/ id=#
 * 2. View its comments
 * 3. Submit a comment for it
 */


/**
 * Always takes a video id as a GET parameter.
 * Shows the video.
 * If comment form data was submitted as POST data then save it in the database.
 * Presents all approved comments for this video.
 * Presents a form for submitting a comment.
 */

require("../../includes/initialize.php");
if (empty($_GET['id'])) {
  $session->message("No video ID was provided.");
  redirect_to('../index.php');
}

$video = EmbedXternal::find_by_id($_GET['id']);
if(!$video) {
  $session->message("The video could not be retrieved from the database.");
  redirect_to('../index.php');
}

// Kick out if video id is for a non-visible video.
if(!$video->visible) {
  $session->message("Your request to view a hidden video was denied.");
  redirect_to('../index.php');
}

if(isset($_POST['submit'])) {
  $author = trim($_POST['author']);
  $author_email = trim($_POST['author_email']);
  $body = trim($_POST['body']);

  $new_comment = CommentOnEmbedXternal::make($video->id, $author_email, $author, $body);

  if($new_comment && $new_comment->save()) {
 
    $session->message("Your comment was submitted and will appear pending approval.");

    // Send email asking Sameh to make comment visible.
    $new_comment->try_to_send_notification();

    // You could let the page render from here. 
    // But then if the page is reloaded, the browser 
    // will make a POST request (rather than a GET.)
    redirect_to("video.php?id=".$video->id);

  } else {
    // Ordinarly we would have a $error to elaborate on the failre.
    $message = "There was an error which prevented the comment from being saved.";
  }
} else {
  $author = "";
  $body = "";
	$author_email = "";
}

$comments = $video->visible_comments();

include_layout_template('header.php');
?>

<a href="../index.php">&laquo; Welcome Page</a><br />
<br />

<div style="margin-left: 20px;">
  <?php echo $video->embed_code; ?>
  <div><?php echo $video->caption; ?></div>
</div>

<div id="comments">
  <?php foreach($comments as $comment): ?>
    <div class="comment" style="margin-bottom: 2em;">
      <div class="author">
        <?php echo htmlentities($comment->author); ?> wrote:
      </div>
      <div class="body">
        <?php echo strip_tags($comment->body, '<a><strong><em><p>'); ?>
      </div>
      <div class="meta-info" style="font-size: 0.8em;">
        <?php echo datetime_to_text($comment->created); ?>
      </div>
    </div>
  <?php endforeach; ?>
  <?php if(empty($comments)) { echo "No Comments."; } ?>
</div>

<div id="comment-form">
  <h3>New Comment for the video on this page</h3>
  <?php echo output_message($message); ?>
  <form action="video.php?id=<?php echo $video->id; ?>" method="post">
    <table>
      <tr>
        <td>Your name:</td>
        <td><input type="text" name="author" value="<?php echo $author; ?>" /></td>
      </tr>
      <tr>
        <td>Your email (is only for our admin's use):</td>
        <td><input type="text" name="author" value="<?php echo $author_email; ?>" /></td>
      </tr>
      <tr>
        <td>Your comment:</td>
        <td><textarea name="body" cols="40" rows="8"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit" value="Submit Comment" /></td>
      </tr>
    </table>
  </form>
</div>

<?php include_layout_template('footer.php'); ?>

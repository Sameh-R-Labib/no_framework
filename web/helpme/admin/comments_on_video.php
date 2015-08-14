<?php
/**
 * Enables an admin to access the individual comments to update them.
 */

require("../../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }

if(empty($_GET['id'])) {
  $session->message("No video ID was provided.");
  redirect_to('list_videos.php');
}

$video = EmbedXternal::find_by_id($_GET['id']);
if(!$video) {
  $session->message("The video could not be located.");
  redirect_to('list_videos.php');
}

$comments = $video->comments();

include_layout_template('admin_header.php');
?>

<a href="list_videos.php">&laquo; Back</a><br />
<br />

<h2>Comments on <?php echo htmlentities($video->route_for_page); ?></h2>

<?php echo output_message($message); ?>

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
        <?php echo datetime_to_text($comment->current_time); ?>
      </div>
      <div class="actions" style="font-size: 0.8em;">
        <a href="update_commentonvideo.php?id=<?php echo htmlentities($comment->id); ?>">Update Comment</a>
      </div>
    </div>
  <?php endforeach; ?>
  <?php if(empty($comments)) { echo "No Comments."; } ?>
</div>

<?php include_layout_template('admin_footer.php'); ?>

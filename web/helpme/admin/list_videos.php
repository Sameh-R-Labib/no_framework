<?php
/**
 * Enables admin access to all videos so that he/she can access their scripts for:
 *   1. comments_on_video.php
 *   2. delete_video.php
 *   3. update_video.php
 * Enables admin to access:
 *   add_video.php
 */

require("../../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }

// Find all the photos
$videos = EmbedXternal::find_all();

include_layout_template('admin_header.php');
?>

<h2>Videos</h2>

<?php echo output_message($message); ?>

<p>Only, delete a video if it has mallicious code. Otherwise, if you don't want it on BusCompanyX.com, just make the video invisible.</p>

<table class="bordered">
  <tr>
    <th>Title</th>
    <th>Caption</th>
    <th>Visible</th>
    <th>Author</th>
    <th>Email</th>
    <th>Time Updated</th>
    <th>Update</th>
    <th>Delete</th>
    <th>Comments</th>
  </tr>
<?php 
// Rows of table:
foreach($videos as $video):
?>
  <tr>
    <td><a href="video.php?id=<?php echo $video->id; ?>"><?php echo htmlentities($video->route_for_page); ?></a></td>
    <td><?php echo strip_tags($video->caption, '<a><strong><em><p>'); ?></td>
    <td><?php echo $video->visible ? 'visible' : 'hidden'; ?></td>
    <td><?php echo htmlentities($video->author); ?></td>
    <td><?php echo htmlentities($video->author_email); ?></td>
    <td><?php echo datetime_to_text($video->time_created); ?></td>
    <td><a href="update_video.php?id=<?php echo htmlentities($video->id); ?>">Update</a></td>
    <td><a href="delete_video.php?id=<?php echo htmlentities($video->id); ?>">Delete</a></td>
    <td><a href="comments_on_video.php?id=<?php echo htmlentities($video->id); ?>"><?php echo $video->comment_count();?></td>
  </tr>
<?php
endforeach;
?>
</table>
<br />
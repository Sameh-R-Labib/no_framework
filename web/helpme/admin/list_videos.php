<?php require("../../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }

// Find all the photos
$videos = EmbedXternal::find_all();

include_layout_template('admin_header.php');
?>

<h2>Videos</h2>

<?php echo output_message($message); ?>

<?php echo output_message($message); ?>
<table class="bordered">
  <tr>
    <th>Caption</th>
    <th>Visible</th>
    <th>Author</th>
    <th>Email</th>
    <th>Time Updated</th>
    <th>URI</th>
    <th>&nbsp;</th>
  </tr>
<?php 
// Rows of table:
foreach($videos as $video):
?>
  <tr>
    <td><?php echo strip_tags($video->caption, '<a><strong><em><p>'); ?></td>
    <td><?php if ($video->visible) {
			echo 'Visible';
			} else {
				echo 'Hidden';
			} ?></td>
    <td><?php echo htmlentities($video->author); ?></td>
    <td><?php echo htmlentities($video->author_email); ?></td>
    <td><?php echo datetime_to_text($video->time_created); ?></td>
    <td><a href="../video.php?id=<?php echo $video->id; ?>"><?php echo htmlentities($video->route_for_page); ?></a></td>
    <td><a href="delete_video.php?id=<?php echo $video->id; ?>">Delete</a></td>
  </tr>
<?php
endforeach;
?>
</table>
<br />
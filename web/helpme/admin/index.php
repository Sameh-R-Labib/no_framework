<?php
/**
 * Presents links to admin scripts.
 */

require('../../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php include_layout_template('admin_header.php'); ?>

<a href="../index.php">&laquo; Back</a><br /><br />

<h2>Menu</h2>

<?php echo output_message($message); ?>

<p><a href="logout.php">Logout</a></p>

<p><a href="logfile.php">View Log file</a></p>

<h3>Videos</h3>

<ul>
  <li><a href="add_video.php">Add Admin Videos</a></li>
  <li><a href="list_videos.php">Manage Videos and Their Comments</a></li>
</ul>

<h3>Photo Gallery</h3>

<ul>
  <li><a href="photo_upload.php">Photo Upload</a></li>
  <li><a href="list_photos.php">List Photos</a></li>
  <li></li>
</ul>

<h3>E-mailing</h3>
<ul>
  <li><a href="sendemail.php">Test Email Sending</a></li>
  <li><a href="sendemail2.php">Test PHPMailer Email Sending</a></li>
</ul>

<?php include_layout_template('admin_footer.php'); ?>



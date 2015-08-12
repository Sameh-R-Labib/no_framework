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
<ul>
  <li><a href="add_video.php">Add Video to Database</a></li>
  <li><a href="list_photos.php">List Photos</a></li>
  <li><a href="photo_upload.php">Photo Upload</a></li>
  <li><a href="logfile.php">View Log file</a></li>
  <li><a href="logout.php">Logout</a></li>
  <li><a href="sendemail.php">Test Email Sending</a></li>
  <li><a href="sendemail2.php">Test PHPMailer Email Sending</a></li>
</ul>

<?php include_layout_template('admin_footer.php'); ?>



<?php require("../../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>
<?php
  // Find all the photos
  $photos = Photograph::find_all();
?>
<?php include_layout_template('admin_header.php'); ?>

<h2>Photographs</h2>

<?php echo output_message($message); ?>
<table class="bordered">
  <tr>
    <th>Image</th>
    <th>Filename</th>
    <th>Caption</th>
    <th>Size</th>
    <th>Type</th>
    <th>Comments</th>
    <th>&nbsp;</th>
  </tr>
<?php foreach($photos as $photo): ?>
  <tr>
    <td><img src="../../<?php echo $photo->image_path(); ?>" width="100" /></td>
    <td><?php echo htmlentities($photo->filename); ?></td>
    <td><?php echo htmlentities($photo->caption); ?></td>
    <td><?php echo $photo->size_as_text(); ?></td>
    <td><?php echo $photo->type; ?></td>
    <td>
      <a href="comments.php?id=<?php echo htmlentities($photo->id); ?>">
        <?php echo $photo->comment_count(); ?>
      </a>
    </td>
    <td><a href="delete_photo.php?id=<?php echo htmlentities($photo->id); ?>">Delete</a></td>
  </tr>
<?php endforeach; ?>
</table>
<br />
<a href="photo_upload.php">Upload a new photograph</a>

<?php include_layout_template('admin_footer.php'); ?>

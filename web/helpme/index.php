<?php
  require_once("../../includes/initialize.php");
  // Find all photos
  $photos = Photograph::find_all();
?>

<?php include_layout_template('header.php'); ?>

<?php foreach($photos as $photo): ?>
  <?php $filepath="../".$photo->image_path(); ?>
  <div style="float: left; margin-left: 20px;">
    <a href="photo.php?id=<?php echo $photo->id; ?>">
      <img src="<?php echo $filepath; ?>" width="200" />
    </a>
    <p><?php echo $photo->caption; ?></p>
  </div>
<?php endforeach; ?>

<?php include_layout_template('footer.php'); ?>

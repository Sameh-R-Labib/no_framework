<?php
  require_once("../../includes/initialize.php");

  // 1. the current page number ($current_page)
  $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

  // 2. records per page ($per_page)
  $per_page = 3;

  // 3. total record count ($total_count)
  $total_count = Photograph::count_all();


  // Find all photos
  // use pagination instead
  //$photos = Photograph::find_all();

  $pagination = new Pagination($page, $per_page, $total_count);

  // Instead of finding all records, just find the records 
  // for this page
  $sql = "SELECT * FROM photographs ";
  $sql .= "LIMIT {$per_page} ";
  $sql .= "OFFSET {$pagination->offset()}";
  $photos = Photograph::find_by_sql($sql);

  // Need to add ?page=$page to all links we want to 
  // maintain the current page (or store $page in $session)

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

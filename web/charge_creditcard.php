<?php require('../includes/initialize.php'); ?>

<?php include_layout_template('home_header.php'); ?>



<?php
//if ( isset($_GET['clear']) && $_GET['clear'] == 'true') {
//  file_put_contents($logfile, '');
  // Add the first log entry
//  log_action('Logs Cleared', "by User ID {$session->user_id}");
  // redirect to this same page so that the URL won't 
  // have "clear=true" anymore
//  redirect_to('logfile.php');
//}
?>


<pre><?php print_r ($_POST); ?></pre>



<?php
  include_layout_template('home_footer.php');
//  if(isset($database)) { $database->close_connection(); }
?>

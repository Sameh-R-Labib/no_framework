<?php require("../../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a><br />
<br />

<h2>Test Email Sending</h2>

<?php echo output_message($message); ?>

<?php


  $curr_time = strftime("%T", time());
  $to = "Sameh Labib <schoolbuscompany@gmail.com>";
  $subject = "Mail Test at $curr_time";
  $message = "This is a test.";
  
  $from = "SAMEH R Labib LLC <superuser@buscompanyx.com>";
  $headers = "From: {$from}";
  
  $result = mail($to, $subject, $message, $headers);

  echo $result ? "Sent: $curr_time" : 'Error: no email was sent';  
?>

<?php include_layout_template('admin_footer.php'); ?>

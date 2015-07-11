<?php require_once("../../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a><br />
<br />

<h2>Test Sending Email using PHPMailer</h2>

<?php echo output_message($message); ?>

<?php

  // Include the PHPMailer classes


  $mail = new PHPMailer();

  $mail->FromName = "SAMEH R LABIB LLC";
  $mail->From     = "superuser@buscompanyx.com";
  $mail->AddAddress("schoolbuscompany@gmail.com", "Sameh R. Labib");
  $mail->Subject  = "Mail Test at ".strftime("%T", time());
  $mail->Body     = "Test Sending Email using PHPMailer";

  $result = $mail->Send();
  echo $result ? 'Sent' : 'Error';

?>

<?php include_layout_template('admin_footer.php'); ?>

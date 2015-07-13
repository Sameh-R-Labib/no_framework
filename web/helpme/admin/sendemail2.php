<?php require_once("../../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a><br />
<br />

<h2>Test Sending Email using PHPMailer</h2>

<?php echo output_message($message); ?>

<?php
  $mail = new PHPMailer;
  $mail->From     = 'superuser@buscompanyx.com';
  $mail->FromName = 'BusCompanyX.com App';
  $mail->addAddress('schoolbuscompany@gmail.com', 'Sameh R. Labib');
  $mail->Subject  = 'Test email sent at '.strftime('%T', time());
  $mail->Body     = 'Body of PHPMailer Test Email Sending using.';

	if(!$mail->send()) {
	    echo 'Message could not be sent. '."<br />\n";
	    echo 'Mailer Error: '.$mail->ErrorInfo."<br />\n";
	} else {
	    echo 'Message has been sent'."<br />\n";
	}
?>

<?php include_layout_template('admin_footer.php'); ?>

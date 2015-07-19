<?php require('../includes/initialize.php'); ?>

<?php
/*
If this script was reached because the payment form
was submitted then I can expect the $_POST array to
look something like:
Array
(
    [stripeToken] => tok_16Q2aXKQDIQFKnT1lC4tdvGz
    [stripeTokenType] => card
    [stripeEmail] => schoolbuscompany@gmail.com
)

If the script was loaded directly then the $_POST array
would be empty.

If the user forged the payment form and tried to send
it to this script then process the form as usual.
*/


if ( !isset($_POST['stripeToken']) ) {
  $session->message("Do not access this page directly.");
  redirect_to('index.php');
}
?>


<?php include_layout_template('home_header.php'); ?>

<h2>Thanks!</h2>

<a href="index.php">&laquo; Home Page</a><br />

<pre><?php print_r ($_POST); ?></pre>

<?php
  include_layout_template('home_footer.php');
//  if(isset($database)) { $database->close_connection(); }
?>

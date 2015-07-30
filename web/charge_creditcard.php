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

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

// Create the charge on Stripe's servers - this will charge the user's card
try {
$charge = \Stripe\Charge::create(array(
  "amount" => 3000, // amount in cents, again
  "currency" => "usd",
  "source" => $token,
  "description" => "Example charge")
);
} catch(\Stripe\Error\Card $e) {
  // The card has been declined
}

$author = trim($_POST['author']);
$authoremail = trim($_POST['authoremail']);
$comment = trim($_POST['comment']);

// Save the comment

?>

<?php include_layout_template('home_header.php'); ?>

<h2>Thanks!</h2>

<pre><?php echo print_r($_POST); ?></pre>

<a href="index.php">&laquo; Home Page</a><br />

<?php
  include_layout_template('home_footer.php');
//  if(isset($database)) { $database->close_connection(); }
?>

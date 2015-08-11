<?php require('../includes/initialize.php');

/*
[stripeToken]     => tok_16Q2aXKQDIQFKnT1lC4tdvGz
[stripeTokenType] => card
[stripeEmail]     => schoolbuscompany@gmail.com
*/

$flagged = false;

if ( !isset($_POST['stripeToken']) ) {
  $session->message("You've erroneously accessed a page directly.");
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

// Validate $_POST data
if (isset($_POST['caption'])) {
	$caption = trim($_POST['caption']);
} else {
	$caption = '';
}
if (isset($_POST['embed_code'])) {
	$embed_code = trim($_POST['embed_code']);
} else {
	$embed_code = '';
}
// Checkbox is Zero pending approval
	$visible_video = 0;
	$visible_comment = 0;
	// Text
if (isset($_POST['author'])) {
	$author = trim($_POST['author']);
} else {
	$author = '';
}
if (isset($_POST['author_email'])) {
	$author_email = trim($_POST['author_email']);
} else {
	$author_email = '';
}
if (isset($_POST['route_for_page'])) {
	$route_for_page = trim($_POST['route_for_page']);
} else {
	$route_for_page = '';
}
if (isset($_POST['body'])) {
	$body = trim($_POST['body']);
} else {
	$body = '';
}


if(!empty($body)) {
	// There is a Comment
	
	// Instantiate a CommentOnVideo
	$commentOnVideo = CommentOnVideo::make(HOMEPAGEEMBEDEDECID, $author, 	$author_email, $body, $visible_comment);
	
	
	if (!$commentOnVideo) {
		$session->message('Unable to instantiate the CommentOnVideo object
			because $body was empty.');
		redirect_to('index.php');
	}

	if ($commentOnVideo->save()) {
		
		// Email notification asking Sameh to make comment visible.
		$commentOnVideo->try_to_send_notification();
	
		$message = "Your comment was saved. ";
	} else {
		$message_buffer = "Unable to save the CommentOnVideo object. ";
		$flagged = true;
	}
}

if(!empty($embed_code)) {
	// There is a Video
	
	// Instantiate an EmbedXternal
	$newVideo = EmbedXternal::make($caption, $embed_code, $visible,
	$author, $author_email, $route_for_page);
	
	if (!$newVideo) {
		$session->message('Unable to instantiate the EmbedXternal object
			because $embed_code was empty.');
		redirect_to('index.php');
	}

	if ($newVideo->save()) {
		
		// Email notification asking Sameh to make video visible.
		$newVideo->try_to_send_notification();
		
		$message .= "Your video embed was saved.";
	} else {
		$session->message($message_buffer."Unable to save the EmbedXternal object.");
		redirect_to('index.php');
	}
}

if($flagged) {
	$session->message($message_buffer);
	redirect_to('index.php');
}

?>

<?php include_layout_template('home_header.php'); ?>

<h2>Thanks!</h2>

<?php echo output_message($message); ?>

<pre><?php echo print_r($_POST); ?></pre>

<a href="index.php">&laquo; Home Page</a><br />

<?php
  include_layout_template('home_footer.php');
//  if(isset($database)) { $database->close_connection(); }
?>

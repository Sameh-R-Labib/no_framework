<?php require("../includes/initialize.php"); ?>

<?php include_layout_template('home_header.php'); ?>

<a href="helpme/index.php">Public Page &raquo;</a><br />

<h2>Welcome Page</h2>

<?php echo output_message($message); ?>

<?php
// Retrieve the EmbedXternal Object from db.
$eEO = EmbedXternal::find_by_id(HOMEPAGEEMBEDEDECID);
if(!$eEO) {
  $session->message("The embed external content could not be retrieved.");
  redirect_to('index.php');
}

// Output the embed code
echo $eEO->embed_code;

$comments = $eEO->comments();


?>

<p>For a fee you can enter a comment for this video and/or add a video page like this one. The subject matter must contribute to the growth of this project. So,
your content will appear pending approval.</p>

<form action="charge_creditcard.php" method="POST">
  <table>
    <tr>
      <td>Author</td>
      <td><input type="text" name="author" maxlength="39" value="" /></td>
    </tr>
    <tr>
      <td>Author Email (won't show in post)</td>
      <td><input type="text" name="author_email" maxlength="79" value="" /></td>
    </tr>
    <tr>
      <td>Comment for this Welcome Page. Your comment can have some HTML tags except for &lt;strong&gt;&lt;em&gt;&lt;p&gt;</td>
      <td><textarea name="body" maxlength="3500" cols="70" rows="2"></textarea></td>
    </tr>
    <tr>
      <td>Embed Code for a Video Page</td>
      <td>
        <input type="text" name="embed_code" maxlength="3000" value="" />
      </td>
    </tr>
    <tr>
      <td>Caption for Video</td>
      <td>
        <input type="text" name="caption" maxlength="139" value="" />
      </td>
    </tr>
		<tr>
			<td>Unique File Name for Your Video Page like "suggestion_for_homepage". It can't have spaces. And I'll be adding the file extension.</td>
			<td><input type="text" name="route_for_page" maxlength="255" value="" /></td>
		</tr>
  </table>
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?php echo $myStripePubKey; ?>"
    data-amount="3000"
    data-name="BusCompanyX.com"
    data-description="by SAMEH R LABIB, LLC"
    data-image="/images/USA.png"
    data-label="Test the payment system"
    data-zip-code="true">
  </script>
</form>

<h3>Comments</h3>

<div id="comments">
  <?php foreach($comments as $comment): ?>
    <div class="comment" style="margin-bottom: 2em;">
      <div class="author">
        <?php echo htmlentities($comment->author); ?> wrote:
      </div>
      <div class="body">
        <?php echo strip_tags($comment->body, '<strong><em><p>'); ?>
      </div>
      <div class="meta-info" style="font-size: 0.8em;">
        <?php echo datetime_to_text($comment->created); ?>
      </div>
    </div>
  <?php endforeach; ?>
  <?php if(empty($comments)) { echo "No Comments."; } ?>
</div>

<?php include_layout_template('home_footer.php'); ?>

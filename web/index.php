<?php require("../includes/initialize.php"); ?>

<?php include_layout_template('home_header.php'); ?>

<a href="helpme/video.php?id=2">Videos posted to BusCompanyX.com &raquo;</a><br />

<h2>Welcome Page</h2>

<?php echo output_message($message); ?>

<?php
// Retrieve the EmbedXternal Object from db.
$eEO = EmbedXternal::find_by_id(HOMEPAGEEMBEDEDECID);
if(!$eEO) {
  $session->message("The video could not be retrieved from the database.");
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
      <td>Comment for this Welcome Page can have &lt;a&gt;&lt;strong&gt;&lt;em&gt;&lt;p&gt;</td>
      <td><textarea name="body" maxlength="3500" cols="70" rows="2"></textarea></td>
    </tr>
    <tr>
      <td>Embed Code for a Video Page</td>
      <td>
        <input type="text" name="embed_code" maxlength="3000" value="" />
      </td>
    </tr>
    <tr>
      <td>Caption for Video (some html tags ok)</td>
      <td>
        <input type="text" name="caption" maxlength="139" value="" />
      </td>
    </tr>
		<tr>
			<td>Hyperlink Text (NO html tags)</td>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="https://cdn.supportkit.io/supportkit.min.js"></script>
<script>
SupportKit.init({appToken: '3xsxvwci5p649stp0yi1by8dl'});
</script>


<?php include_layout_template('home_footer.php'); ?>

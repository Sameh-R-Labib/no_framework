<?php
/**
 * Allows public users to:
 *   1. See Welcome Video
 *   2. Submit comment for Welcome Video, or
 *   3. Submit Their Own Video
 *   4. View comments of others for Welcome Video
 */
require("../includes/initialize.php");
include_layout_template('home_header.php');

// Link to user contributed videos
?>
<a href="helpme/visible_videos.php">Feature wish list videos for BusCompanyX.com functionality &raquo;</a>
 || <a href="helpme/admin/index.php">admin &raquo;</a><br /><br />

<h2>Welcome Page</h2>

<?php
// Display session message
echo output_message($message);


// Retrieve the EmbedXternal Object from db.
$video = EmbedXternal::find_by_id(HOMEPAGEEMBEDEDECID);
if(!$video) {
  $session->message("The video could not be retrieved from the database.");
  redirect_to('index.php');
}

// Output the embed code
echo $video->embed_code;

// Get its comments
$comments = $video->visible_comments();
?>

<p>For a small fee you can enter a comment and/or add a video. The topic must be constructive and relevant to this project. Your content will display if/when approved.</p>

<form action="charge_creditcard.php" method="POST">
  <table>
  <col width="280">
  <col width="400">
    <tr>
      <td height="50">Full Name (real name please)</td>
      <td height="50"><input type="text" name="author" maxlength="39" value="" /></td>
    </tr>
    <tr>
      <td height="50">Author Email (won't apear in post)</td>
      <td height="50"><input type="text" name="author_email" maxlength="79" value="" /></td>
    </tr>
    <tr>
      <td height="75">Your comment about the video above (some html tags are ok)</td>
      <td height="75"><textarea name="body" maxlength="3500" cols="52" rows="3"></textarea></td>
    </tr>
    <tr>
      <td height="75">The Embed Code for your video</td>
      <td height="75"><textarea name="embed_code" maxlength="3500" cols="52" rows="3"></textarea></td>
    </tr>
    <tr>
      <td height="50">Caption for Video (some html tags are ok)</td>
      <td height="50"><input type="text" name="caption" maxlength="139" value="" /></td>
    </tr>
		<tr>
			<td height="50">A Title for Your Video (don't use html tags)</td>
			<td height="50"><input type="text" name="route_for_page" maxlength="255" value="" /></td>
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
        <?php echo strip_tags($comment->body, '<a><strong><em><p>'); ?>
      </div>
      <div class="meta-info" style="font-size: 0.8em;">
        <?php echo datetime_to_text($comment->current_time); ?>
      </div>
    </div>
  <?php endforeach; ?>
  <?php if(empty($comments)) { echo "No Comments yet!"; } ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="https://cdn.supportkit.io/supportkit.min.js"></script>
<script>
SupportKit.init({
  appToken: '3xsxvwci5p649stp0yi1by8dl',
  givenName: 'App developer',
  surname: 'Sam',
  email: 'schoolbuscompany@gmail.com',
  properties: {'jobTitle': 'business owner'}
});
</script>


<?php include_layout_template('home_footer.php'); ?>

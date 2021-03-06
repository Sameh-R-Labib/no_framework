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
<a href="fb_login.php">Login (using Facebook)</a> | <a href="privacy_policy.php">Privacy policy</a> | <a href="tos.php">Terms of Service</a> | <a href="helpme/visible_videos.php">Feature wish list videos for BusCompanyX.com functionality &raquo;</a>
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

<h3>Your Feedback</h3>

<p>&Fopf;or a small fee you can enter a comment, video, or both. The topic must be relevant. Your content will appear only after it is approved. You don't have to fill out *all* the form fields. To submit a video you'll need to make a screen cast; Then upload it to YouTube. Afterwards, you can get the embed code from YouTubes Share feature. I use ScreenFlow (mac only) to make screen casts. YouTube has tutorials on how to make screen casts and many other interesting things! Thanks in advance&iinfin;</p>

<form action="charge_creditcard.php" method="POST">
  <table>
  <col width="242">
  <col width="400">
    <tr>
      <td height="30">Full Name (real name)</td>
      <td height="30"><input type="text" name="author" maxlength="39" value="" /></td>
    </tr>
    <tr>
      <td height="30">Author Email (won't apear)</td>
      <td height="30"><input type="text" name="author_email" maxlength="79" value="" /></td>
    </tr>
    <tr>
      <td height="60">Your comment about my video (some html ok)</td>
      <td height="60"><textarea name="body" maxlength="3500" cols="52" rows="3"></textarea></td>
    </tr>
    <tr>
      <td height="60">Your video's embed code</td>
      <td height="60"><textarea name="embed_code" maxlength="3500" cols="52" rows="3"></textarea></td>
    </tr>
    <tr>
      <td height="30">Caption for video (some html ok)</td>
      <td height="30"><input type="text" name="caption" maxlength="139" value="" /></td>
    </tr>
		<tr>
			<td height="30">A Title for Your Video (no html)</td>
			<td height="30"><input type="text" name="route_for_page" maxlength="255" value="" /></td>
		</tr>
  </table>
  <script
    src="https://checkout.stripe.com/checkout.js"
    class="stripe-button"
    data-key="<?php echo $myStripePubKey; ?>"
    data-amount="700"
    data-name="BusCompanyX.com"
    data-description="by SAMEH R LABIB, LLC"
    data-image="/images/USA.png"
    data-label="Fund this Endeavor"
    data-zip-code="true"
  >
  </script>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="https://cdn.supportkit.io/supportkit.min.js"></script>
<script>
SupportKit.init({
  appToken: '3xsxvwci5p649stp0yi1by8dl',
  givenName: 'BusCompanyX.com User',
  surname: 'Anonymous',
  email: 'user@gmail.com',
  properties: {'jobTitle': 'funding contributor'}
});
</script>

<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>

<?php include_layout_template('home_footer.php'); ?>

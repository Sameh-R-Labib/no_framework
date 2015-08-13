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
<a href="helpme/visible_videos.php">Videos posted to BusCompanyX.com &raquo;</a><br />

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

<p>If you make a credit card payment then you can enter a comment for this video and/or add a video page of your own. The topic must be constructive for this project. Your content will appear if approved.</p>

<form action="charge_creditcard.php" method="POST">
  <table>
    <tr>
      <td>Author</td>
      <td><input type="text" name="author" maxlength="39" value="" /></td>
    </tr>
    <tr>
      <td>Author Email - Fear not! It won't apear next to your post.</td>
      <td><input type="text" name="author_email" maxlength="79" value="" /></td>
    </tr>
    <tr>
      <td>Your comment about the video above. It can have &lt;a&gt;&lt;strong&gt;&lt;em&gt;&lt;p&gt;</td>
      <td><textarea name="body" maxlength="3500" cols="110" rows="3"></textarea></td>
    </tr>
    <tr>
      <td>The Embed Code for a Video Page of Your Own</td>
      <td><textarea name="embed_code" maxlength="3500" cols="110" rows="3"></textarea></td>
    </tr>
    <tr>
      <td>Caption for Video (some html tags are ok)</td>
      <td><input type="text" name="caption" maxlength="139" value="" /></td>
    </tr>
		<tr>
			<td>A Title for Your Video (NO html tags)</td>
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
SupportKit.init({
  appToken: '3xsxvwci5p649stp0yi1by8dl',
  givenName: 'App developer',
  surname: 'Sam',
  email: 'schoolbuscompany@gmail.com',
  properties: {'jobTitle': 'business owner'}
});
</script>


<?php include_layout_template('home_footer.php'); ?>

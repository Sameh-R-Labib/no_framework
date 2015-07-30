<?php
  require("../includes/initialize.php");
	
	$embededEC_id = HOMEPAGEEMBEDEDECID;
?>

<?php include_layout_template('home_header.php'); ?>

<h2>Meetup next Thu July 30th, 2015 6:30 PM Glen Burnie, MD</h2>

<?php echo output_message($message); ?>

<p>
<a href="http://www.meetup.com/Linthicum-no_framework-PHP-Project/events/224046847/">RSVP</a>
<br /> <b>To see who's interested and what they bring to the table.</b></p>

<p>Link to <a href="helpme/index.php">public</a> area.</p>

<iframe width="853" height="480" src="https://www.youtube.com/embed/wdCdMTBS_qg" frameborder="0" allowfullscreen></iframe>

<form action="charge_creditcard.php" method="POST">
  <table>
    <tr>
      <td>Name:</td>
      <td><input type="text" name="author" value="" /></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><input type="text" name="authoremail" value="" /></td>
    </tr>
    <tr>
      <td>Comment:</td>
      <td><textarea name="comment" cols="70" rows="2"></textarea></td>
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

<?php include_layout_template('home_footer.php'); ?>

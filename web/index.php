<?php
  require("../includes/initialize.php");
?>

<?php include_layout_template('home_header.php'); ?>

<h2>Meetup next Thu July 30th, 2015 6:30 PM Glen Burnie, MD</h2>

<?php echo output_message($message); ?>

<p><a href="http://www.meetup.com/Linthicum-no_framework-PHP-Project/events/224046847/" data-event="224046847" class="mu-rsvp-btn">RSVP</a><br />
  <b>To see who's interested and what they bring to the table.</b></p>

<p>Link to <a href="helpme/index.php">public</a> area.</p>

<iframe width="1280" height="720" src="https://www.youtube.com/embed/wdCdMTBS_qg" frameborder="0" allowfullscreen></iframe>

<form action="charge_creditcard.php" method="POST">
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

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s); js.id=id;js.async=true;js.src="https://a248.e.akamai.net/secure.meetupstatic.com/s/script/541522619002077648/api/mu.btns.js?id=si0v63rlsn2bdl7p8vtf54pse1";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","mu-bootjs");</script>

<?php include_layout_template('home_footer.php'); ?>

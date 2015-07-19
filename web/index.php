<?php
  require("../includes/initialize.php");
?>

<?php include_layout_template('home_header.php'); ?>

<h2>Home Page</h2>

<?php echo output_message($message); ?>

<ul>
	<li>Site under construction</li>
	<li>You are in BusCompanyX.com home</li>
	<li>To go to <a href="helpme/index.php">BusCompanyX.com public</a> click on the link.</li>
</ul>

<iframe width="1280" height="720" src="https://www.youtube.com/embed/wdCdMTBS_qg" frameborder="0" allowfullscreen></iframe>

<form action="charge_creditcard.php" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_qmnMXmCGIzRRwG64UhA5VgXY"
    data-amount="10000"
    data-name="BusCompanyX.com"
    data-description="by SAMEH R LABIB, LLC"
    data-image="/images/USA.png"
    data-label="Test the payment system"
    data-zip-code="true">
  </script>
</form>

<?php include_layout_template('home_footer.php'); ?>

<?php
  require_once("../includes/initialize.php");
?>

<?php include_layout_template('home_header.php'); ?>

<div>This site is under construction.</div>
<div>You are in BusCompanyX.com public</div>
<div><a href="helpme/index.php">Go to BusCompanyX.com public</a></div>

<iframe width="1280" height="720" src="https://www.youtube.com/embed/wdCdMTBS_qg" frameborder="0" allowfullscreen></iframe>

<form action="" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_qmnMXmCGIzRRwG64UhA5VgXY"
    data-amount="2000"
    data-name="Demo Site"
    data-description="2 widgets ($20.00)"
    data-image="/images/USA.png">
  </script>
</form>

<?php include_layout_template('home_footer.php'); ?>

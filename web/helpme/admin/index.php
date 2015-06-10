<?php
require_once('../../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<html>
  <head>
    <title>BusCompanyX: helpme</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link href="../../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div id="header">
      <h1>BusCompanyX: helpme</h1>
    </div>
    <div id="main">
      <h2>Menu</h2>

    </div>

    <div id="footer">Copyright <?php echo date("Y", time()); ?>, Sameh R. Labib</div>
  </body>
</html>

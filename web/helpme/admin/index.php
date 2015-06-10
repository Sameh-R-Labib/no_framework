<?php
require_once('../../../includes/functions.php');
require_once('../../../includes/session.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<html>
  <head>
    <title>BusCompanyX: helpme</title>
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

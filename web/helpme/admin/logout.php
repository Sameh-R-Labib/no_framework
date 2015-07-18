<?php
require("../../../includes/initialize.php");	
$session->logout();
redirect_to("login.php");
?>

<?php
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("admin/login.php"); }
?>

<?php include_layout_template('header.php'); ?>

<?php
$user = User::find_by_id(1);
echo $user->full_name();

echo "<hr />";

$users = User::find_all();
foreach($users as $user) {
  echo "User: ". $user->username ."<br />";
  echo "Name: ". $user->full_name() ."<br /><br />";
}
?>

<?php include_layout_template('footer.php'); ?>

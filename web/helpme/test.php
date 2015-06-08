<?php
//Script to test whether MySQLDatabase.php connects to the database.

require_once("../../includes/MySQLDatabase.php");
require_once("../../includes/user.php");

if(isset($database)) { echo "true"; } else { echo "false"; }
echo "<br />";

echo $database->escape_value("It's working?<br />");

//$sql  = "INSERT INTO users (id, username, password, first_name, last_name) ";
//$sql .= "VALUES (1, 'kskoglund', 'secretpwd', 'Kevin', 'Skoglund')";
//$result = $database->query($sql);

$sql = "SELECT * FROM users WHERE id=1";
$result = $database->query($sql);
$found_user = $database->fetch_array($result);
echo $found_user['username'];

echo "<hr />";

$found_user = User::find_by_id(1);
echo $found_user['username'];

echo "<hr />";

$user_set = User::find_all();
while ($user = $database->fetch_array($user_set)) {
  echo "User: ". $user['username'] ."<br />";
  echo "Name: ". $user['first_name'] . " " . $user['last_name'] ."<br /><br />";
}

?>

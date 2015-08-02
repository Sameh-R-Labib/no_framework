<?php
// INCLUDE INITIALIZE AND KICK OUT IF NOT LOGGED IN
require("../../../includes/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?PHP // PROCESS A SUBMITTED FORM'S DATA ?>
<?php if (isset($_POST['submit'])) {

		// PREPARE DATA SET WHICH CAME FROM SUBMIT
		if (isset($_POST['caption'])) {
			$caption = trim($_POST['caption']);
		} else {
			$caption = '';
		}
    if (isset($_POST['embed_code'])) {
    	$embed_code = trim($_POST['embed_code']);
    } else {
    	$embed_code = '';
    }
 		if (isset($_POST['visible']) && $_POST['visible'] == '1') {
			$visible = 1;
		} else {
			$visible = 0;
		}
	  if (isset($_POST['author'])) {
    	$author = $_POST['author'];
    } else {
    	$author = '';
    }
    if (isset($_POST['author_email'])) {
    	$author_email = $_POST['author_email'];
    } else {
    	$author_email = '';
    }
    if (isset($_POST['route_for_page'])) {
    	$route_for_page = $_POST['route_for_page'];
    } else {
    	$route_for_page = '';
    }
 		
		// INSTANTIATE AN EmbedXternal OBJECT
		$newEEC = EmbedXternal::make($caption, $embed_code, $visible,
		$author, $author_email, $route_for_page);

		// SAVE THAT OBJECT
		if (!$newEEC) {
			$session->message('Unable to instantiate the EmbedXternal object
				because $embed_code was empty.');
			redirect_to('add_video.php');
		}
		if ($newEEC->save()) {
			$session->message("Your embed was saved.");
			redirect_to('add_video.php');
		} else {
			$session->message("Unable to save the EmbedXternal object.");
			redirect_to('add_video.php');
		}
} ?>
	
<?php // DISPLAY THE FORM FOR ACCEPTING A NEW EmbedXternal OBJECT ?>
<?PHP // SHOW TOP OF THE PAGE  ?>
<?php include_layout_template('admin_header.php'); ?>

<?PHP // SHOW BACK LINK ?>
<a href="index.php">&laquo; Back</a><br /><br />

<?PHP // SHOW TITLE OF THE PAGE ?>
<h2>Add Embeded External Content to Its Database Table</h2>

<?PHP // SHOW MESSAGE ?>
<?php echo output_message($message); ?>

<?PHP // SHOW FORM ?>
<form action="add_video.php" method="post">
  <table>
    <tr>
      <td>Caption:</td>
      <td>
        <input type="text" name="caption" maxlength="139" value="" />
      </td>
    </tr>
    <tr>
      <td>Embed Code:</td>
      <td>
        <input type="text" name="embed_code" maxlength="3000" value="" />
      </td>
    </tr>
		<tr>
			<td>Visible</td>
			<td><input type="checkbox" name="visible" value="1" /></td>
		</tr>
		<tr>
			<td>Author</td>
			<td><input type="text" name="author" maxlength="39" value="" /></td>
		</tr>
		<tr>
			<td>Author Email</td>
			<td><input type="text" name="author_email" maxlength="79" value="" /></td>
		</tr>
		<tr>
			<td>Hyperlink Text</td>
			<td><input type="text" name="route_for_page" maxlength="255" value="" /></td>
		</tr>
    <tr>
      <td colspan="2"><input type="submit" name="submit" value="Go" /></td>
    </tr>
  </table>
</form>

<?PHP // SHOW BOTTOM OF THE PAGE ?>
<?php include_layout_template('admin_footer.php'); ?>

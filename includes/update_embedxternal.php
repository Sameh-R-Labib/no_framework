<?php
	// INCLUDE INITIALIZE 
	require("../../../includes/initialize.php");
?>

<?php	// Am I responding to a POST request?
			// If yes (which is what this block takes care of)
			// then update the db using data from $_POST

if (isset($_POST['submit'])) {

	// EXTRACT DATA FROM $_POST

	// id is special. As an attribute it can't be updated using any class
	// method other than create(). And that is why we will have to explicitly
	// set its value below. Thus breaking our abstraction layer.
	// Another thing. This script needs to always know the value of id.
	// So, we pass it along from one page request to the next. First,
	// as a GET parameter. Then as a hidden POST parameter.
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	} else {
		$id = '';
	}
	// time_created will be reset by make() so there is no sense
	// dealing with it at all in this script
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
  	$author_email = trim($_POST['author_email']);
  } else {
  	$author_email = '';
  }
  if (isset($_POST['route_for_page'])) {
  	$route_for_page = trim($_POST['route_for_page']);
  } else {
  	$route_for_page = '';
  }
	
	// INSTANTIATE AN EmbedXternal OBJECT
	$newEEC = EmbedXternal::make($caption, $embed_code, $visible,
	$author, $author_email, $route_for_page);
	if (!$newEEC) {
		$session->message('Unable to instantiate the EmbedXternal object
			because $embed_code was empty.');
		redirect_to("update_embedxternal.php/id=".$id);
	}
	
	// ASSIGN THE OBJECT ITS ORIGINAL ID
	// The reason we are just taking this step now is that make() does not
	// assign a value for id. Its just part of the code design.
	$newEEC->id = $id;

	// UPDATE THAT OBJECT
	if ($newEEC->update()) {
		$session->message("Your embed was updated.");
		redirect_to("update_embedxternal.php/id=".$id);
	} else {
		$session->message("Unable to update the EmbedXternal object.");
		redirect_to("update_embedxternal.php/id=".$id);
	}
}
?>

<?php
// Am I responding to a GET request?
// If Yes then read the data from the database
// so I can use it to pre-fill the form fields.
if(!empty($_GET['id'] && is_numeric($_GET['id']))) {
	// Then assume it's a GET request
	
	$eXC = EmbedXternal::find_by_id($_GET['id']);
  if(!$eXC) {
    $session->message("The EmbedXternal could not be located.");
    redirect_to('list_embedxternal.php');
  }
	
	// Copy the attribs to vars.
	$attributes = $eXC->attributes();
	extract($attributes);
}
?>

<?php
// SHOW TOP OF THE PAGE
include_layout_template('admin_header.php');
?>
<a href="index.php">&laquo; Back</a><br /><br />
<h2>Add Embeded External Content to Its Database Table</h2>

<?php
// SHOW MESSAGE
echo output_message($message);
?>

<?php
// SHOW FORM
if($visible) {
	$checkbox = '<input type="checkbox" name="visible" value="1" checked="checked" />';
} else {
	$checkbox = '<input type="checkbox" name="visible" value="1" />';
}
?>
<form action="update_embedxternal.php" method="post">
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table>
    <tr>
      <td>Caption:</td>
      <td>
        <input type="text" name="caption" maxlength="139" value="<?php echo $caption; ?>" />
      </td>
    </tr>
    <tr>
      <td>Embed Code:</td>
      <td>
        <input type="text" name="embed_code" maxlength="3000" value="<?php echo $embed_code; ?>" />
      </td>
    </tr>
		<tr>
			<td>Visible</td>
			<td><?php echo $checkbox; ?></td>
		</tr>
		<tr>
			<td>Author</td>
			<td><input type="text" name="author" maxlength="39" value="<?php echo $author; ?>" /></td>
		</tr>
		<tr>
			<td>Author Email</td>
			<td><input type="text" name="author_email" maxlength="79" value="<?php echo $author_email; ?>" /></td>
		</tr>
		<tr>
			<td>Route (i.e. /helpme/index.php)</td>
			<td><input type="text" name="route_for_page" maxlength="255" value="<?php echo $route_for_page; ?>" /></td>
		</tr>
    <tr>
      <td colspan="2"><input type="submit" name="submit" value="Go" /></td>
    </tr>
  </table>
</form>


<?php
// SHOW BOTTOM OF THE PAGE
include_layout_template('admin_footer.php');
?>

<?php
  require("../../../includes/initialize.php");

  if (isset($_POST['submit'])) {
		// Transfer POST data to vars
    $caption = trim($_POST['caption']);
    $embed_code = trim($_POST['embed_code']);
 		
		// Instantiate an EmbededExternalContent
		// based on submitted data.
		$newEEC = EmbededExternalContent::make($caption, $embed_code);
		
		if ($newEEC && $newEEC->save()) {
			
			// Formulate a message string indicating the Save
			$session->message("Your embed was saved.");
			// Redirect to self script
			redirect_to('add_embeded_external_content.php');
			
		} else {
			
			// Formulate a message saying the Save did not happen
			$session->message("The embed was NOT saved.");
			// Redirect to self script
			redirect_to('add_embeded_external_content.php');
			
		}
	}
?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a><br /><br />

<h2>Add Embeded External Content to Its Database Table</h2>

<?php echo output_message($message); ?>

<form action="add_embeded_external_content.php" method="post">
  <table>
    <tr>
      <td>Caption:</td>
      <td>
        <input type="text" name="caption" maxlength="140" value="" />
      </td>
    </tr>
    <tr>
      <td>Embed Code:</td>
      <td>
        <input type="text" name="embed_code" maxlength="3000" value="" />
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="submit" name="submit" value="Go" />
      </td>
    </tr>
  </table>
</form>
<?php include_layout_template('admin_footer.php'); ?>

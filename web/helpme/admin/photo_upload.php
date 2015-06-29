<?php
  require_once('../../includes/initialize.php');
  if (!$session->is_logged_in()) { redirect_to("login.php"); }
  // The MAX_FILE_SIZE hidden field (measured in bytes) must precede
  // the file input field, and its value is the maximum filesize accepted
  // by PHP. This form element should always be used as it saves users the
  // trouble of waiting for a big file being transferred only to find that
  // it was too large and the transfer failed.
  //
  // zingaburga at hotmail dot com COMMENTED on PHP.NET
  // http://php.net/manual/en/features.file-upload.post-method.php
  //
  // STATING:
  // The documentation is a little unclear about the MAX_FILE_SIZE value sent in the
  // form with multiple file input fields.  The following is what I have found
  // through testing - hopefully it may clarify it for others.
  //
  // The MAX_FILE_SIZE is applied to each file (not the total size of all files)
  // and to all file inputs which appear after it.  This means that it can be
  // overridden for different file fields.  You can also disable it by sending no
  // number, or sending 0 (probably anything that == '0' if you think about it).
  //
  // Example:
  //
  // <form enctype="multipart/form-data" action="." method="POST">
  // <!-- no maximum size for userfile0 -->
  // <input name="userfile0" type="file" />
  //
  // <input type="hidden" name="MAX_FILE_SIZE" value="1000" />
  // <!-- maximum size for userfile1 is 1000 bytes -->
  // <input name="userfile1" type="file" />
  // <!-- maximum size for userfile2 is 1000 bytes -->
  // <input name="userfile2" type="file" />
  //
  // <input type="hidden" name="MAX_FILE_SIZE" value="2000" />
  // <!-- maximum size for userfile3 is 2000 bytes -->
  // <input name="userfile3" type="file" />
  //
  // <input type="hidden" name="MAX_FILE_SIZE" value="0" />
  // <!-- no maximum size for userfile4 -->
  // <input name="userfile4" type="file" />
  // </form>
  $max_file_size = 318767104;   // expressed in bytes
                              //     10240 =  10 KB
                              //    102400 = 100 KB
                              //   1048576 =   1 MB
                              //  10485760 =  10 MB
  $message = "";
  if (isset($_POST['submit'])) {
    $photo = new Photograph();
    $photo->caption = $_POST['caption'];
    $photo->attach_file($_FILES['file_upload']);
    if($photo->save()) {
      // Success
      $message = "Photograph uploaded successfully.";
    } else {
      // Failure
      $message = join("<br />", $photo->errors);
    }
  }
?>
  <?php include_layout_template('admin_header.php'); ?>
  <h2>Photo Upload</h2>
  <?php php echo output_message($message); ?>
  <form action="photo_upload.php" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
    <p><input type="file" name="file_upload" /></p>
    <p>Caption: <input type="text" name="caption" value="" /></p>
    <input type="submit" name="submit" value="Upload" />
  </form>
  <?php include_layout_template('admin_footer.php'); ?>

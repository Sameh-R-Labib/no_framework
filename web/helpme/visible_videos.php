<?php
/**
 * Lists all the visible user contributed videos as hyperlinked text.
 * Uses pagination.
 * Gets/puts video id from/to session; Or, just uses the query string value.
 *
 */
require("../../includes/initialize.php");

// $page_number gets its value from the session if a page number is there.
// Otherwise, $page number=1.
$page_number = $session->visible_videos_page() ? $session->visible_videos_page() : 1;

// If $_GET['page'] has a valid page number the use that page number.
// Otherwise, use $page_number as the page number.
$visible_videos_page_number = !empty($_GET['page']) ? (int)$_GET['page'] : $page_number;
$per_page = 2;
$count_of_visible_videos = EmbedXternal::count_of_visible_videos();

$pagination = new Pagination($visible_videos_page_number, $per_page, $count_of_visible_videos);

$sql = "SELECT * FROM embedxternal ";
$sql .= "WHERE visible=1 ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";

$videos = EmbedXternal::find_by_sql($sql);

// $visible_videos_page_number is being stored in the session so that when the user clicks on a
// link to visible_videos.php without the page number in the query string he/she doesn't have to
// start at page 1.
$session->visible_videos_page_number($visible_videos_page_number);

include_layout_template('header.php');
foreach($videos as $video):
?>
  <div style="float: left; margin-left: 20px;">
    <div><a href="video.php?id=<?php echo $video->id; ?>">$video->route_for_page</a></div>
    <p><?php echo $video->caption; ?></p>
  </div>
<?php
endforeach;
?>

<div id="pagination" style="clear: both;">
<?php
if($pagination->total_pages() > 1) {
    
  if($pagination->has_previous_page()) { 
    echo '<a href="visible_videos.php?page=';
    echo $pagination->previous_page();
    echo '">&laquo; Previous</a> '; 
  }

  for($i=1; $i <= $pagination->total_pages(); $i++) {
    if($i == $visible_videos_page_number) {
      echo " <span class=\"selected\">{$i}</span> ";
    } else {
      echo " <a href=\"visible_videos.php?page={$i}\">{$i}</a> ";
    }
  }

  if($pagination->has_next_page()) { 
    echo ' <a href="visible_videos.php?page=';
    echo $pagination->next_page();
    echo '">Next &raquo;</a> '; 
  }
    
}
?>
</div>

<?php include_layout_template('footer.php'); ?>
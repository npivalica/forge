<?php require_once('../private/initialize.php'); ?>

<?php
$preview = false;
if (isset($_GET['preview'])) {
  // previewing should require admin to be logged in
  $preview = $_GET['preview'] == 'true' && is_logged_in() ? true : false;
}
$visible = !$preview;

if (isset($_GET['id'])) {
  $page_id = $_GET['id'];
  $page = find_page_by_id($page_id, ['visible' => $visible]);
  if (!$page) {
    redirect_to(url_for('/index.php'));
  }
  $subject_id = $page['subject_id'];
} else {
  //nothing is selected, show the static homepage
}
?>

<?php include(SHARED_PATH . '/public_header.php'); ?>

<div id="main">
  <?php include(SHARED_PATH . '/public_navigation.php'); ?>

  <div id="page">
    <?php

    if (isset($page)) {
      # show page from database
      echo $page['content'];
    } else {
      //static homepage which will be overrun with dynamic content
      include(SHARED_PATH . '/static_author_page.php');
    }


    ?>

  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
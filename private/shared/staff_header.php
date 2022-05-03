<?php
if (!isset($page_title)) {
  $page_title = 'Staff Area';
}
?>

<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="This is forge staff area." />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="robots" content="noindex,follow" />
  <meta name="language" content="english">
  <meta name="keywords" content="cms, staff, subjects, pages, bank, forge" />
  <title>forge - <?php echo htmlspecialchars($page_title); ?></title>
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo url_for('/stylesheets/staff.css'); ?>" />
  <link rel="shortcut icon" href="<?php echo url_for('favicon.ico'); ?>" />

</head>

<body>
  <header>
    <h1>forge Staff Area</h1>
  </header>

  <navigation>
    <ul>
      <?php if (is_logged_in()) { ?>
        <li>User: <?php echo $_SESSION['username'] ?? ''; ?></li>
        <li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
        <li><a href="<?php echo url_for('/staff/logout.php'); ?>">Log out</a></li>
      <?php } ?>
    </ul>
  </navigation>
  <?php echo display_session_message(); ?>
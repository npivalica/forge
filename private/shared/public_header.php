<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="This is home page for forge bank where you can read all about our services and latest news." />
  <meta name="keywords" content="bank, forge, loan, mortgage, home" />
  <meta name="robots" content="noindex,follow" />
  <meta name="language" content="english">
  <title>forge
    <?php
    if (isset($page_title)) {
      echo '- ' . htmlspecialchars($page_title);
    }
    if (isset($preview) && $preview) {
      echo ' [PREVIEW]';
    }
    ?>
  </title>
  <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/public.css'); ?>" />
  <link rel="shortcut icon" href="<?php echo url_for('favicon.ico'); ?>" />

</head>

<body>

  <header>
    <h1>
      <a href="<?php echo url_for('/index.php'); ?>">
        <img src="<?php echo url_for('/images/logo.png'); ?>" alt="" />
      </a>
    </h1>
  </header>
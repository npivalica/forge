<!doctype html>

<html lang="en">
  <head>
    <title>forge 
      <?php 
      if(isset($page_title)) { 
        echo '- ' . htmlspecialchars($page_title);
      }
      if (isset($preview) && $preview) {
        echo ' [PREVIEW]';
      }
      ?>
      </title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/public.css'); ?>" />
  </head>

  <body>

    <header>
      <h1>
        <a href="<?php echo url_for('/index.php'); ?>">
          <img src="<?php echo url_for('/images/logo.png'); ?>"  alt="" />
        </a>
      </h1>
    </header>

<?php
$service_set = find_all_services();
?>

<div id="hero-image">
  <img src="images/homepage_assets/world_in_hands_900px.png" alt="Woman holding a globe in her hand" />
</div>

<div id="content">
  <h2>At forge Bank, we have the products and customer service to back up our "worldly" claims. Give us a try, and you'll see we stand by our values and our customers.</h2>
  <div id="service-blocks">
    <?php foreach ($service_set as $service) { ?>
      <div class="service">
        <img src="images/homepage_assets/<?php echo htmlspecialchars($service['img_src']) ?>" alt="<?php echo htmlspecialchars($service['img_alt']) ?>" />
        <h1><?php echo htmlspecialchars($service['title']) ?></h1>
        <p><?php echo htmlspecialchars($service['description']) ?></p>
      </div>
    <?php } ?>
  </div>
</div>
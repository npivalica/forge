<?php
    $subject_id = $subject_id ?? '';
    $page_id = $page_id ?? '';
    $visible = $visible ?? true;
?>
<navigation>
  <?php $nav_subjects = find_all_subjects(['visible' => $visible]); ?>
  <ul class="subjects">

    <?php foreach ($nav_subjects as $nav_subject) { ?>

      <li class="<?php if ($nav_subject['id'] == $subject_id) {echo 'selected';} ?>">

        <a href="<?php echo url_for('index.php'); ?>">
          <?php echo htmlspecialchars($nav_subject['menu_name']); ?>
        </a>

        <?php $nav_pages = find_pages_by_subject_id($nav_subject['id'], ['visible' => $visible]); ?>
        <ul class="pages">

          <?php foreach ($nav_pages as $nav_page) { ?>
            <li class="<?php if ($nav_page['id'] == $page_id) {
                          echo 'selected';
                        } ?>">
              <a href="<?php echo url_for('index.php?id=' . htmlspecialchars(urlencode($nav_page['id']))); ?>">
                <?php echo htmlspecialchars($nav_page['menu_name']); ?>
              </a>
            </li>
          <?php } //end of the loop for pages 
          ?>

        </ul>

      </li>

    <?php } //end of the loop for subjects
    ?>

  </ul>

</navigation>
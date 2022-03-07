<?php require_once('../../../private/initialize.php'); ?>

<?php

$subject_set = find_all_subjects();

?>

<?php $page_title = 'Subjects'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="subjects listing">
    <h1>Subjects</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/subjects/new.php'); ?>">Create New Subject</a>
    </div>

    <table class="list">
      <tr>
        <th>ID</th>
        <th>Position</th>
        <th>Visible</th>
        <th>Name</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <?php foreach ($subject_set as $subject) { ?>
        <tr>
          <td><?php echo htmlspecialchars($subject['id']); ?></td>
          <td><?php echo htmlspecialchars($subject['position']); ?></td>
          <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
          <td><?php echo htmlspecialchars($subject['menu_name']); ?></td>
          <td><a class="action" href="<?php echo url_for('/staff/subjects/show.php?id=' . htmlspecialchars(urlencode($subject['id']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/subjects/edit.php?id=' . htmlspecialchars(urlencode($subject['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/subjects/delete.php?id=' . htmlspecialchars(urlencode($subject['id']))); ?>">Delete</a></td>
        </tr>
      <?php } ?>
    </table>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
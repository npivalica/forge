<?php

require_once('../../../private/initialize.php');

$id = $_GET['id'] ?? '1'; // PHP > 7.0
$admin = find_admin_by_id($id);

?>

<?php $page_title = 'Show Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin show">

    <h1>Admin: <?php echo htmlspecialchars($admin['username']); ?></h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/admins/edit.php?id=' . htmlspecialchars(urlencode($admin['id']))); ?>">Edit</a>
      <a class="action" href="<?php echo url_for('/staff/admins/delete.php?id=' . htmlspecialchars(urlencode($admin['id']))); ?>">Delete</a>
    </div>

    <div class="attributes">
      <dl>
        <dt>First name</dt>
        <dd><?php echo htmlspecialchars($admin['first_name']); ?></dd>
      </dl>
      <dl>
        <dt>Last name</dt>
        <dd><?php echo htmlspecialchars($admin['last_name']); ?></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><?php echo htmlspecialchars($admin['email']); ?></dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><?php echo htmlspecialchars($admin['username']); ?></dd>
      </dl>
    </div>

  </div>

</div>

<?php require_once('../../../private/initialize.php'); ?>
<?php
require_login();

$keyword = $_POST['keyword'] ?? '';
$searchQuery = $connection->prepare("SELECT * FROM `pages` WHERE `content` LIKE '%$keyword%' or `menu_name` LIKE '%$keyword%'");
$searchQuery->execute();
if (isset($_POST['search'])) {
  $page_set = $searchQuery -> fetchAll();
}
else{
  $page_set = find_all_pages();
}
$subject_set = find_all_subjects();
?>

<?php $page_title = 'Pages'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="pages listing">
    <h1>Pages</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/pages/new.php'); ?>">Create New Page</a>
    </div>

    <div class="actions">
      <form method="POST" action="">
        <div>
          <input type="text" name="keyword" placeholder="Search pages by keyword ..." />
          <button name="search">Search</button>
        </div>
      </form>
    </div>

    <!-- <div class="actions">
      <select id="ddlSub">
        <option value="0">Filter pages by subject</option>
        <?php
        foreach ($subject_set as $subject) :
        ?>
          <option value="<?= $subject['id'] ?>"><?= $subject['menu_name'] ?></option>
        <?php
        endforeach;
        ?>
      </select>
    </div> -->

    <div id="pagesList">
      <table class="list">
        <tr>
          <th>ID</th>
          <th>Subject</th>
          <th>Position</th>
          <th>Visible</th>
          <th>Name</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>


        <?php foreach ($page_set as $page) { ?>
          <?php $subject = find_subject_by_id($page['subject_id']); ?>
          <tr>
            <td><?php echo htmlspecialchars($page['id']); ?></td>
            <td><?php echo htmlspecialchars($subject['menu_name']); ?></td>
            <td><?php echo htmlspecialchars($page['position']); ?></td>
            <td><?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></td>
            <td><?php echo htmlspecialchars($page['menu_name']); ?></td>
            <td><a class="action" href="<?php echo url_for('/staff/pages/show.php?id=' . htmlspecialchars(urlencode($page['id']))); ?>">View</a></td>
            <td><a class="action" href="<?php echo url_for('/staff/pages/edit.php?id=' . htmlspecialchars(urlencode($page['id']))); ?>">Edit</a></td>
            <td><a class="action" href="<?php echo url_for('/staff/pages/delete.php?id=' . htmlspecialchars(urlencode($page['id']))); ?>">Delete</a></td>
          </tr>
        <?php }
        unset($keyword);?>
      </table>
    </div>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
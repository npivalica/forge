<?php
require_once ('../../../private/initialize.php');

$id = $_GET['id'] ?? '1';
echo htmlspecialchars($id);

$page_title="Show Subject";
include(SHARED_PATH . '/staff_header.php');
?>

<div id="content">
    <a href="<?php echo url_for('/staff/subjects/index.php'); ?>" class="back-link">$laquo; Back To List</a>
    <div class="subject show">
        Subject ID: <?php echo htmlspecialchars($id);?>
    </div>
</div>
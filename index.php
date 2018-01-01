<?php require('init.php');
ob_start();
if (!isset($_SESSION['username'])): ?>
<h3>Login to upload files.</h3>
<?php else: ?>
<h3>Connected, you can now upload files.</h3><br>
<?php include('files.php')?>
<?php endif;
$content = ob_get_contents();
ob_end_clean();
require('layout.php');


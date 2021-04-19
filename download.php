<?php include ('views/header-script.php'); ?>
<?php 
$file_path = "img/profile/user.jpg";

$coreControl->safeDownload($file_path, "hi.jpg");

?>

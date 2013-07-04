<?php require_once('../Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
session_start();
if(!isset($_SESSION['user_name'])) {
	header('Location: index.php');
}
if(isset($_GET['image_id'])) {
	$image_id = $_GET['image_id'];
	mysql_select_db($database_connAutoPress, $connAutoPress);
	$query = 'DELETE FROM images WHERE image_id="'.$image_id.'"';
	$result = mysql_query($query, $connAutoPress) or die;
	$target = 'admin.php?pageNum_rs_images='.$_GET['pageNum_rs_images'].'&totalRows_rs_images='.($_GET['totalRows_rs_images']-1);
}
if(isset($_GET['category_id'])) {
	$category_id = $_GET['category_id'];
	mysql_select_db($database_connAutoPress, $connAutoPress);
	$query = 'DELETE FROM categories WHERE category_id="'.$category_id.'"';
	$result = mysql_query($query, $connAutoPress) or die;
	$target = 'cat_list.php';
}
header(sprintf("Location: %s", $target));
exit;
?>

<?php require_once('../Connections/connAutoPress.php');
session_start();
mysql_select_db($database_connAutoPress, $connAutoPress);
if(!isset($_SESSION['user_name'])) {
	header('Location: index.php');
}
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_images = 23;
$pageNum_rs_images = 0;
if (isset($_GET['pageNum_rs_images'])) {
  $pageNum_rs_images = $_GET['pageNum_rs_images'];
}
$startRow_rs_images = $pageNum_rs_images * $maxRows_rs_images;

if(isset($_GET['sort'])) {
	$sort = $_GET['sort'];
	$query_rs_images = "SELECT sections.name AS section, categories.name AS category, DATE_FORMAT(categories.date,'%d/%m/%y') AS f_date, images.*, if(images.title IS NULL || images.title='NULL','',images.title) AS newtitle FROM images LEFT JOIN categories USING (category_id) LEFT JOIN sections USING (section_id) WHERE 1 ORDER BY ".$sort." ASC";
} elseif (isset($_SESSION['admin_query'])) {
	$query_rs_images = $_SESSION['admin_query'];
} else {
	$sort = 'category_id';
	$query_rs_images = "SELECT sections.name AS section, categories.name AS category, DATE_FORMAT(categories.date,'%d/%m/%y') AS f_date, images.*, if(images.title IS NULL || images.title='NULL','',images.title) AS newtitle FROM images LEFT JOIN categories USING (category_id) LEFT JOIN sections USING (section_id) WHERE 1 ORDER BY ".$sort." ASC";
}
$query_limit_rs_images = sprintf("%s LIMIT %d, %d", $query_rs_images, $startRow_rs_images, $maxRows_rs_images);
$rs_images = mysql_query($query_limit_rs_images, $connAutoPress);
$row_rs_images = mysql_fetch_assoc($rs_images);
$_SESSION['admin_query'] = $query_rs_images;

if (isset($_GET['totalRows_rs_images'])) {
  $totalRows_rs_images = $_GET['totalRows_rs_images'];
} else {
  $all_rs_images = mysql_query($query_rs_images);
  $totalRows_rs_images = mysql_num_rows($all_rs_images);
}
$totalPages_rs_images = ceil($totalRows_rs_images/$maxRows_rs_images)-1;

$queryString_rs_images = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_images") == false && 
        stristr($param, "totalRows_rs_images") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_images = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_images = sprintf("&totalRows_rs_images=%d%s", $totalRows_rs_images, $queryString_rs_images);
?>
<html>
<head>
<title>auto-press: administration</title>
<meta http-equiv="Content-Type" content="text/html;">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="imagetoolbar" content="false">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="imagetoolbar" content="false">
<link href="autopress.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW | innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function chk_delete(image_id, query_string) {
	if(confirm("Please confirm DELETE")) {
		window.location="delete.php?image_id="+image_id+"&"+query_string
	} else {
		window.location="admin.php?"+query_string
	}
} 
//-->
</script>
</head>
<body>
<table width="890" align="center" cellpadding="0" cellspacing="0" class="admin_panel">
  <tr>
   <td>
     <span class="title"><img src="../design/logosmall.gif" width="300" height="65"></span>     </td>
   <td><div align="center"><strong><img src="../design/t_administration.gif" width="150" height="13">&nbsp;</strong></div></td>
  </tr>
  <tr>
   <td colspan="2">  
   <table width="100%" cellpadding="1" cellspacing="0">
     <tr>
       <td id="text"><strong>A list of all the images on file.</strong></td>
       <td><div align="left"><a href="index.php?logout=y"><img src="../design/btnReturn.gif" alt="Log out" width="35" height="35" border="0"></a></div></td>
     </tr>
   </table>   
   <br> 
        <table width="100%" border="0" cellpadding="0" cellspacing="3" id="text">
          <tr>
            <td>Click on a column header to sort by that column.</td>
            <td><div align="right">Page <?php echo $pageNum_rs_images+1 ?> of <?php echo $totalPages_rs_images+1 ?></div></td>
          </tr>
      </table>
      <table width="700" border="1" align="center" cellpadding="0" cellspacing="3" id="text">
       <tr bordercolor="#FFFFFF">
         <td><strong><a href="admin.php?sort=section">Section</a></strong></td>
         <td><strong><a href="admin.php?sort=category">Event</a></strong></td>
         <td><strong><a href="admin.php?sort=categories.date">Date</a></strong></td>
         <td><strong><a href="admin.php?sort=title">Title</a></strong></td>
         <td><strong><a href="admin.php?sort=file_name">File name</a></strong></td>
         <td><strong><a href="admin.php?sort=display">Display</a></strong></td>
         <td><strong>Loaded</strong></td>
         <td colspan="2"><div align="center"><a href="add.php"><img src="button_add.png" width="11" height="13" border="0"></a></div></td>
        </tr>
       <?php do { ?>
       <tr bordercolor="#FFFFFF">
         <td><?php echo $row_rs_images['section']; ?></td>
         <td><?php echo $row_rs_images['category']; ?></td>
         <td><?php echo $row_rs_images['f_date']; ?></td>
         <td><?php echo $row_rs_images['newtitle']; ?></td>
         <td><?php echo $row_rs_images['file_name']; ?></td>
         <td><div align="center"><?php echo ($row_rs_images['display']=='TRUE' ? 'Y' : ''); ?>
          </div></td>
         <td><div align="center"><?php echo (file_exists('../images/'.$row_rs_images['file_name']) ? 'Y' : ''); ?>
          </div></td>
         <td><a href="amend.php?image_id=<?php echo $row_rs_images['image_id'] ?>&pageNum_rs_images=<?php echo $pageNum_rs_images ?>&totalRows_rs_images=<?php echo $totalRows_rs_images ?>"><img src="button_edit.png" border="0"></a></td>
         <td><a href="Javascript:; chk_delete('<?php echo $row_rs_images['image_id'] ?>', '<?php echo 'pageNum_rs_images='.$pageNum_rs_images.'&totalRows_rs_images='.$totalRows_rs_images ;?>')"><img src="button_delete.png" border="0"></a></td>
       </tr>
       <?php } while ($row_rs_images = mysql_fetch_assoc($rs_images)); ?>
     </table>
      <table border="0" width="50%" align="center" class="text">
       <tr>
         <td width="25" align="center">
           <?php if ($pageNum_rs_images > 0) { // Show if not first page ?>
           <a href="<?php printf("%s?pageNum_rs_images=%d%s", $currentPage, 0, $queryString_rs_images); ?>"><img src="../design/First.gif" width="18" height="13" border=0></a>
           <?php } // Show if not first page ?>         </td>
         <td width="25" align="center">
           <?php if ($pageNum_rs_images > 0) { // Show if not first page ?>
           <a href="<?php printf("%s?pageNum_rs_images=%d%s", $currentPage, max(0, $pageNum_rs_images - 1), $queryString_rs_images); ?>"><img src="../design/Previous.gif" width="14" height="13" border=0></a>
           <?php } // Show if not first page ?>         </td>
         <td align="center" id="title">
		 <?php for($i=1; $i<=$totalPages_rs_images+1; $i++) {
		 	echo ($i!=$pageNum_rs_images+1 ? '<a href="'.sprintf("%s?pageNum_rs_images=%d%s", $currentPage, $i-1, $queryString_rs_images).'">'.$i.'</a>  ' :  $i.'  ');
		 } ?>
		 </td>
         <td width="25" align="center">
           <?php if ($pageNum_rs_images < $totalPages_rs_images) { // Show if not last page ?>
           <a href="<?php printf("%s?pageNum_rs_images=%d%s", $currentPage, min($totalPages_rs_images, $pageNum_rs_images + 1), $queryString_rs_images); ?>"><img src="../design/Next.gif" width="14" height="13" border=0></a>
           <?php } // Show if not last page ?></td>
         <td width="25" align="center">
           <?php if ($pageNum_rs_images < $totalPages_rs_images) { // Show if not last page ?>
           <a href="<?php printf("%s?pageNum_rs_images=%d%s", $currentPage, $totalPages_rs_images, $queryString_rs_images); ?>"><img src="../design/Last.gif" width="18" height="13" border=0></a>
           <?php } // Show if not last page ?></td>
       </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

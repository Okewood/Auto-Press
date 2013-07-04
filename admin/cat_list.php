<?php require_once('../Connections/connAutoPress.php');
session_start();
mysql_select_db($database_connAutoPress, $connAutoPress);
if(!isset($_SESSION['user_name'])) {
	header('Location: index.php');
}
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_categories = 23;
$pageNum_rs_categories = 0;
if (isset($_GET['pageNum_rs_categories'])) {
  $pageNum_rs_categories = $_GET['pageNum_rs_categories'];
}
$startRow_rs_categories = $pageNum_rs_categories * $maxRows_rs_categories;

if(isset($_GET['sort'])) {
	$sort = $_GET['sort'];
	$query_rs_categories = "SELECT sections.name AS section, categories.*, date_format(categories.date, '%d/%m/%Y') AS format_date FROM categories LEFT JOIN sections USING (section_id) WHERE categories.name is not null ORDER BY ".$sort." ASC";
} elseif (isset($_SESSION['category_query'])) {
	$query_rs_categories = $_SESSION['category_query'];
} else {
	$sort = 'date';
	$query_rs_categories = "SELECT sections.name AS section, categories.*, date_format(categories.date, '%d/%m/%Y') AS format_date FROM categories LEFT JOIN sections USING (section_id) WHERE categories.name is not null ORDER BY ".$sort." ASC";
}
$query_limit_rs_categories = sprintf("%s LIMIT %d, %d", $query_rs_categories, $startRow_rs_categories, $maxRows_rs_categories);
$rs_categories = mysql_query($query_limit_rs_categories, $connAutoPress) or die;
$row_rs_categories = mysql_fetch_assoc($rs_categories);
$_SESSION['category_query'] = $query_rs_categories;

if (isset($_GET['totalRows_rs_categories'])) {
  $totalRows_rs_categories = $_GET['totalRows_rs_categories'];
} else {
  $all_rs_categories = mysql_query($query_rs_categories);
  $totalRows_rs_categories = mysql_num_rows($all_rs_categories);
}
$totalPages_rs_categories = ceil($totalRows_rs_categories/$maxRows_rs_categories)-1;

$queryString_rs_categories = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_categories") == false && 
        stristr($param, "totalRows_rs_categories") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_categories = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_categories = sprintf("&totalRows_rs_categories=%d%s", $totalRows_rs_categories, $queryString_rs_categories);
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

function chk_delete(category_id, query_string) {
	if(confirm("Please confirm DELETE")) {
		window.location="delete.php?category_id="+category_id+"&"+query_string
	} else {
		window.location="cat_list.php?"+query_string
	}
} 
//-->
</script>
</head>
<body>
<table width="890" height="500" align="center" cellpadding="0" cellspacing="0" class="admin_panel">
  <tr>
   <td height="65">
     <span class="title"><img src="../design/logosmall.gif" width="300" height="65"></span>     </td>
   <td align="center"><img src="../design/t_administration.gif" width="150" height="13">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Current Event list.</strong></td>
    <td align="center"><a href="add.php"><img src="../design/btnReturn.gif" alt="Log out" width="35" height="35" border="0"></a></td>
  </tr>
  <tr valign="top">
   <td colspan="2">   <br> 
        <table width="100%" border="0" cellpadding="0" cellspacing="3" id="text">
          <tr>
            <td>Click on a column header to sort by that column.</td>
            <td><div align="right">Page <?php echo $pageNum_rs_categories+1 ?> of <?php echo $totalPages_rs_categories+1 ?></div></td>
          </tr>
      </table>
      <table width="700" border="1" align="center" cellpadding="0" cellspacing="3" id="text">
       <tr bordercolor="#FFFFFF">
         <td><strong><a href="cat_list.php?sort=section">Section</a></strong></td>
         <td><strong><a href="cat_list.php?sort=name">Name</a></strong></td>
         <td><strong>Description</strong></td>
         <td><div align="center"><strong><a href="cat_list.php?sort=date">Date</a></strong></div></td>
         <td colspan="2"><div align="center"><a href="cat_add.php"><img src="button_add.png" width="11" height="13" border="0"></a></div></td>
        </tr>
       <?php do { ?>
       <tr bordercolor="#FFFFFF">
         <td><?php echo $row_rs_categories['section']; ?></td>
         <td><?php echo $row_rs_categories['name']; ?></td>
         <td><?php echo substr($row_rs_categories['notes'],0,10); ?></td>
         <td><div align="center"><?php echo $row_rs_categories['format_date']; ?></div></td>
         <td><a href="cat_amend.php?category_id=<?php echo $row_rs_categories['category_id'] ?>&pageNum_rs_categories=<?php echo $pageNum_rs_categories ?>&totalRows_rs_categories=<?php echo $totalRows_rs_categories ?>"><img src="button_edit.png" border="0"></a></td>
         <td><a href="Javascript:; chk_delete('<?php echo $row_rs_categories['category_id'] ?>', '<?php echo 'pageNum_rs_categories='.$pageNum_rs_categories.'&totalRows_rs_categories='.$totalRows_rs_categories ;?>')"><img src="button_delete.png" border="0"></a></td>
       </tr>
       <?php } while ($row_rs_categories = mysql_fetch_assoc($rs_categories)); ?>
     </table>
      <table border="0" width="50%" align="center" class="text">
       <tr>
         <td width="25" align="center">
           <?php if ($pageNum_rs_categories > 0) { // Show if not first page ?>
           <a href="<?php printf("%s?pageNum_rs_categories=%d%s", $currentPage, 0, $queryString_rs_categories); ?>"><img src="../design/First.gif" width="18" height="13" border=0></a>
           <?php } // Show if not first page ?>         </td>
         <td width="25" align="center">
           <?php if ($pageNum_rs_categories > 0) { // Show if not first page ?>
           <a href="<?php printf("%s?pageNum_rs_categories=%d%s", $currentPage, max(0, $pageNum_rs_categories - 1), $queryString_rs_categories); ?>"><img src="../design/Previous.gif" width="14" height="13" border=0></a>
           <?php } // Show if not first page ?>         </td>
         <td align="center" id="title">
		 <?php for($i=1; $i<=$totalPages_rs_categories+1; $i++) {
		 	echo ($i!=$pageNum_rs_categories+1 ? '<a href="'.sprintf("%s?pageNum_rs_categories=%d%s", $currentPage, $i-1, $queryString_rs_categories).'">'.$i.'</a>  ' :  $i.'  ');
		 } ?>
		 </td>
         <td width="25" align="center">
           <?php if ($pageNum_rs_categories < $totalPages_rs_categories) { // Show if not last page ?>
           <a href="<?php printf("%s?pageNum_rs_categories=%d%s", $currentPage, min($totalPages_rs_categories, $pageNum_rs_categories + 1), $queryString_rs_categories); ?>"><img src="../design/Next.gif" width="14" height="13" border=0></a>
           <?php } // Show if not last page ?></td>
         <td width="25" align="center">
           <?php if ($pageNum_rs_categories < $totalPages_rs_categories) { // Show if not last page ?>
           <a href="<?php printf("%s?pageNum_rs_categories=%d%s", $currentPage, $totalPages_rs_categories, $queryString_rs_categories); ?>"><img src="../design/Last.gif" width="18" height="13" border=0></a>
           <?php } // Show if not last page ?></td>
       </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

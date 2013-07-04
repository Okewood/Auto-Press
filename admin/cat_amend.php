<?php require_once('../Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
session_start();
if(!isset($_SESSION['user_name'])) {
	header('Location: index.php');
}
require_once('functions.php');
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $date = $_POST['cat_year'].'-'.$_POST['cat_month'].'-'.$_POST['cat_day'];
  $updateSQL = sprintf("UPDATE categories SET section_id=%s, name=%s, date=%s, notes=%s WHERE category_id=%s",
                       GetSQLValueString($_POST['section_id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['category_id'], "int"));

  mysql_select_db($database_connAutoPress, $connAutoPress);
  $Result1 = mysql_query($updateSQL, $connAutoPress) or die;
 
  $insertGoTo = 'cat_list.php';
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connAutoPress, $connAutoPress);
$query_rs_category = "SELECT * FROM categories WHERE category_id = ".$_REQUEST['category_id'];
$rs_category = mysql_query($query_rs_category, $connAutoPress) or die;
$row_rs_category = mysql_fetch_assoc($rs_category);
$totalRows_rs_category = mysql_num_rows($rs_category);
$cat_day = substr($row_rs_category['date'],8,2);
$cat_month = substr($row_rs_category['date'],5,2);
$cat_year = substr($row_rs_category['date'],0,4);

$query_rs_sections = "SELECT * FROM sections WHERE 1";
$rs_sections = mysql_query($query_rs_sections, $connAutoPress) or die;
$row_rs_sections = mysql_fetch_assoc($rs_sections);
$totalRows_rs_sections = mysql_num_rows($rs_sections);
?>
<html>
<head>
<title>Auto Press Site Administration</title>
<meta http-equiv="Content-Type" content="text/html;">
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
//-->
</script>
</head>
<body>
<table width="890" height="500" align="center" cellpadding="0" cellspacing="0" class="admin_panel">
  <tr>
   <td>
     <span class="title"><img src="../design/logosmall.gif" width="300" height="65"></span>     </td>
   <td><div align="center"><strong><img src="../design/t_administration.gif" width="150" height="13">&nbsp;</strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><a href="admin.php"><img src="../design/btnReturn.gif" width="35" height="35" border="0"></a></div></td>
  </tr>
  <tr valign="top">
   <td colspan="2">     <div align="right"><br>
      </div>
     <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
       <table align="center" id="text">
         <tr valign="baseline">
           <td colspan="3" align="left" nowrap><?php echo (isset($feedback) ? '<span id="warning">'.$feedback.'</span>' : '&nbsp;'); ?></td>
          </tr>
         <tr valign="baseline">
           <td nowrap align="right">Section:</td>
           <td><select name="section_id" id="section_id">
             <?php $selected = (isset($_POST['section_id']) ? $_POST['section_id'] : $row_rs_category['section_id']);
			 do {  ?>
             <option value="<?php echo $row_rs_sections['section_id']?>" <?php if (!(strcmp($row_rs_sections['section_id'], $selected))) {echo "SELECTED";} ?>><?php echo $row_rs_sections['name']?></option>
             <?php } while ($row_rs_sections = mysql_fetch_assoc($rs_sections));
			  $rows = mysql_num_rows($rs_sections);
			  if($rows > 0) {
			      mysql_data_seek($rs_sections, 0);
				  $row_rs_sections = mysql_fetch_assoc($rs_sections);
			  } ?>
           </select></td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Event:</td>
           <td><input type="text" name="name" value="<?php echo (isset($_POST['name']) ? $_POST['name'] : $row_rs_category['name']) ?>" size="100"></td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Date:</td>
                     <td><select name="cat_day" id="cat_day">
            <option value=""></option>
            <option value="01"<?php if($cat_day=="01") echo " selected" ?>>01</option>
            <option value="02"<?php if($cat_day=="02") echo " selected" ?>>02</option>
            <option value="03"<?php if($cat_day=="03") echo " selected" ?>>03</option>
            <option value="04"<?php if($cat_day=="04") echo " selected" ?>>04</option>
            <option value="05"<?php if($cat_day=="05") echo " selected" ?>>05</option>
            <option value="06"<?php if($cat_day=="06") echo " selected" ?>>06</option>
            <option value="07"<?php if($cat_day=="07") echo " selected" ?>>07</option>
            <option value="08"<?php if($cat_day=="08") echo " selected" ?>>08</option>
            <option value="09"<?php if($cat_day=="09") echo " selected" ?>>09</option>
            <option value="10"<?php if($cat_day=="10") echo " selected" ?>>10</option>
            <option value="11"<?php if($cat_day=="11") echo " selected" ?>>11</option>
            <option value="12"<?php if($cat_day=="12") echo " selected" ?>>12</option>
            <option value="13"<?php if($cat_day=="13") echo " selected" ?>>13</option>
            <option value="14"<?php if($cat_day=="14") echo " selected" ?>>14</option>
            <option value="15"<?php if($cat_day=="15") echo " selected" ?>>15</option>
            <option value="16"<?php if($cat_day=="16") echo " selected" ?>>16</option>
            <option value="17"<?php if($cat_day=="17") echo " selected" ?>>17</option>
            <option value="18"<?php if($cat_day=="18") echo " selected" ?>>18</option>
            <option value="19"<?php if($cat_day=="19") echo " selected" ?>>19</option>
            <option value="20"<?php if($cat_day=="20") echo " selected" ?>>20</option>
            <option value="21"<?php if($cat_day=="21") echo " selected" ?>>21</option>
            <option value="22"<?php if($cat_day=="22") echo " selected" ?>>22</option>
            <option value="23"<?php if($cat_day=="23") echo " selected" ?>>23</option>
            <option value="24"<?php if($cat_day=="24") echo " selected" ?>>24</option>
            <option value="25"<?php if($cat_day=="25") echo " selected" ?>>25</option>
            <option value="26"<?php if($cat_day=="26") echo " selected" ?>>26</option>
            <option value="27"<?php if($cat_day=="27") echo " selected" ?>>27</option>
            <option value="28"<?php if($cat_day=="28") echo " selected" ?>>28</option>
            <option value="29"<?php if($cat_day=="29") echo " selected" ?>>29</option>
            <option value="30"<?php if($cat_day=="30") echo " selected" ?>>30</option>
            <option value="31"<?php if($cat_day=="31") echo " selected" ?>>31</option>
          </select>
            <select name="cat_month" id="cat_month">
              <option value=""></option>
              <option value="01"<?php if($cat_month=="01") echo " selected" ?>>Jan</option>
              <option value="02"<?php if($cat_month=="02") echo " selected" ?>>Feb</option>
              <option value="03"<?php if($cat_month=="03") echo " selected" ?>>Mar</option>
              <option value="04"<?php if($cat_month=="04") echo " selected" ?>>Apr</option>
              <option value="05"<?php if($cat_month=="05") echo " selected" ?>>May</option>
              <option value="06"<?php if($cat_month=="06") echo " selected" ?>>Jun</option>
              <option value="07"<?php if($cat_month=="07") echo " selected" ?>>Jul</option>
              <option value="08"<?php if($cat_month=="08") echo " selected" ?>>Aug</option>
              <option value="09"<?php if($cat_month=="09") echo " selected" ?>>Sep</option>
              <option value="10"<?php if($cat_month=="10") echo " selected" ?>>Oct</option>
              <option value="11"<?php if($cat_month=="11") echo " selected" ?>>Nov</option>
              <option value="12"<?php if($cat_month=="12") echo " selected" ?>>Dec</option>
            </select>
            <select name="cat_year" id="cat_year">
              <option value=""></option>
             <?php for($i=date('Y')+6; $i>date('Y')-75; $i--) { ?>
				 <option value="<?php echo $i ?>"<?php if($cat_year==$i) echo " selected" ?>><?php echo $i ?></option>
			 <?php } ?>
            </select></td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td align="right" valign="middle" nowrap>Description:</td>
           <td><textarea name="notes" cols="75" rows="5" id="notes"><?php echo $row_rs_category['notes'] ?></textarea></td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">&nbsp;</td>
           <td><input type="submit" class="inputbutton" value="Update record"></td>
           <td>&nbsp;</td>
         </tr>
       </table>
       <input type="hidden" name="category_id" value="<?php echo $row_rs_category['category_id'] ?>">
       <input type="hidden" name="MM_update" value="form1">
    </form>   </td>
  </tr>
</table>
</body>
</html>

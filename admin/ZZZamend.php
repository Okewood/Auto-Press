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
  if(!empty($_FILES['userfile']['name']) || !empty($_POST['file_name'])) {
	  if(!empty($_FILES['userfile']['name']))
	  	$file_name = $_FILES['userfile']['name']; 
	  if(!empty($_POST['file_name']))
		$file_name = (strtoupper(substr($_POST['file_name'],0,-4)=='.JPG') ? substr($_POST['file_name'],0,-4).'.jpg' : $_POST['file_name'].'.jpg');
	  $feedback = upload_jpeg('../temp/', '../images/', (!empty($_POST['file_name']) ? $file_name : ''), 0);
	  if(!$feedback) {
		//if new file uploaded, delete and/or rename as necessary
	  	if(isset($_FILES['userfile']['tmp_name']) && !empty($_FILES['userfile']['tmp_name'])) {
			if( '../images/'.$file_name != '../images/'.$_POST['old_file_name']) {
				unlink('../images/'.$_POST['old_file_name']);
			}
		} else {
    		if(empty($_POST['file_name']) && file_exists('../images/'.$_POST['old_file_name'])) {
	  			unlink('../images/'.$_POST['old_file_name']);
		    }
    		if($_POST['file_name'] != $_POST['old_file_name']) {
  				rename('../images/'.$_POST['old_file_name'], '../images/'.$file_name);
		    }
		}
	  }
  }
  $updateSQL = sprintf("UPDATE images SET section_id=%s, category_id=%s, title=%s, sub_title=%s, frame_size=%s, picture_size=%s, file_name=%s, keywords=%s, display=%s WHERE image_id=%s",
                       GetSQLValueString($_POST['section_id'], "text"),
                       GetSQLValueString($_POST['category_id'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['sub_title'], "text"),
                       GetSQLValueString($_POST['frame_size'], "text"),
                       GetSQLValueString($_POST['picture_size'], "text"),
                       GetSQLValueString($file_name, "text"),
                       GetSQLValueString(strtoupper($_POST['keywords']), "text"),
                       GetSQLValueString($_POST['display'], "text"),
                       GetSQLValueString($_POST['image_id'], "int"));

  mysql_select_db($database_connAutoPress, $connAutoPress);
  $Result1 = mysql_query($updateSQL, $connAutoPress);
 
  $insertGoTo = 'admin.php';
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connAutoPress, $connAutoPress);
$query_rs_image = "SELECT * FROM images WHERE image_id = ".$_REQUEST['image_id'];
$rs_image = mysql_query($query_rs_image, $connAutoPress);
$row_rs_image = mysql_fetch_assoc($rs_image);
$totalRows_rs_image = mysql_num_rows($rs_image);

$query_rs_sections = "SELECT * FROM sections WHERE 1";
$rs_sections = mysql_query($query_rs_sections, $connAutoPress);
$row_rs_sections = mysql_fetch_assoc($rs_sections);
$totalRows_rs_sections = mysql_num_rows($rs_sections);

$query_rs_categories = "SELECT sections.*, categories.*, DATE_FORMAT(categories.date,'%d/%m/%Y') AS format_date FROM categories LEFT JOIN sections USING (section_id) WHERE 1 ORDER BY sections.section_id ASC, categories.date DESC";
$rs_categories = mysql_query($query_rs_categories, $connAutoPress);
$row_rs_categories = mysql_fetch_assoc($rs_categories);
$totalRows_rs_categories = mysql_num_rows($rs_categories);
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
<table width="890" align="center" cellpadding="0" cellspacing="0" class="admin_panel">
  <tr>
   <td>
     <span class="title"><img src="../design/logosmall.gif" width="300" height="65"></span>     </td>
   <td><div align="center"><strong><img src="../design/t_administration.gif" width="150" height="13">&nbsp;</strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><a href="admin.php"><img src="../design/btnReturn.gif" width="35" height="35" border="0"></a></div></td>
  </tr>
  <tr>
   <td colspan="2">     <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
       <table align="center" id="text">
         <tr valign="baseline">
           <td colspan="3" align="left" nowrap><?php echo (isset($feedback) ? '<span id="warning">'.$feedback.'</span>' : '&nbsp;'); ?></td>
          </tr>
         <tr valign="baseline">
           <td nowrap align="right">Section:</td>
           <td><select name="section_id" id="section_id">
             <?php $selected = (isset($_POST['section_id']) ? $_POST['section_id'] : $row_rs_image['section_id']);
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
           <td><select name="category_id" id="category_id">
             <?php $selected = (isset($_POST['category_id']) ? $_POST['category_id'] : $row_rs_image['category_id']);
			 do {  ?>
             <option value="<?php echo $row_rs_categories['category_id']?>" <?php if (!(strcmp($row_rs_categories['category_id'], $selected))) {echo "SELECTED";} ?>><?php echo $row_rs_categories['name'].' '.$row_rs_categories['format_date']?></option>
             <?php } while ($row_rs_categories = mysql_fetch_assoc($rs_categories));
			  $rows = mysql_num_rows($rs_categories);
			  if($rows > 0) {
			      mysql_data_seek($rs_categories, 0);
				  $row_rs_categories = mysql_fetch_assoc($rs_categories);
			  } ?>
           </select></td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Picture title:</td>
           <td><input name="title" type="text" value="<?php echo (isset($_POST['title']) ? $_POST['title'] : $row_rs_image['title']) ?>" size="100"></td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Sub title:</td>
           <td><input name="sub_title" type="text" id="sub_title" value="<?php echo (isset($_POST['sub_title']) ? $_POST['sub_title'] : $row_rs_image['sub_title']) ?>" size="100"></td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td align="right" valign="middle" nowrap>Frame size: </td>
           <td><textarea name="frame_size" cols="25" id="frame_size"><?php echo (isset($_POST['frame_size']) ? $_POST['frame_size'] : stripslashes($row_rs_image['frame_size'])) ?></textarea></td>
           <td valign="baseline">&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td align="right" valign="middle" nowrap>Picture size: </td>
           <td><textarea name="picture_size" cols="25" rows="2" id="picture_size"><?php echo (isset($_POST['picture_size']) ? $_POST['picture_size'] : stripslashes($row_rs_image['picture_size'])) ?></textarea></td>
           <td valign="baseline">&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Keywords:</td>
           <td><input type="text" name="keywords" value="<?php echo (isset($_POST['keywords']) ? $_POST['keywords'] : $row_rs_image['keywords']) ?>" size="100"></td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td align="right" valign="middle" nowrap>Display:</td>
           <td valign="middle">             <p>
               <label>
               <input name="display" type="radio" value="TRUE" <?php echo ($row_rs_image['display']=="TRUE" ? 'checked' : ''); ?>>
  True</label>
               <label>
               <input type="radio" name="display" value="FALSE" <?php echo ($row_rs_image['display']=="FALSE" ? 'checked' : ''); ?>>
  False</label>
               <br>
               <br>
            </p></td>
           <td rowspan="5"><table border="0" align="center" cellpadding="15" cellspacing="0">
             <tr>
               <td valign="middle" class="thumbframe"><img src="../inc_thumb.php?filename=images/<?php echo $row_rs_image['file_name'] ?>" border="0"></td>
             </tr>
           </table></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">&nbsp;</td>
           <td>&nbsp;
            </td>
          </tr>
         <tr valign="baseline">
           <td nowrap align="right">File:</td>
           <td><input name "MAX_FILE_SIZE" type="hidden" value="10000000">
		   <input name="userfile" type="file" class="text" id="userfile" size="85"></td>
          </tr>
         <tr valign="baseline">
           <td nowrap align="right">File name:</td>
           <td><input type="text" name="file_name" value="<?php echo substr($row_rs_image['file_name'],0,-4) ?>" size="32">
.jpg (leave this as shown to retain original file and filename)</td>
          </tr>
         <tr valign="baseline">
           <td nowrap align="right">&nbsp;</td>
           <td>&nbsp;</td>
          </tr>
         <tr valign="baseline">
           <td nowrap align="right">&nbsp;</td>
           <td><input type="submit" class="inputbutton" value="Update record"></td>
           <td>&nbsp;</td>
         </tr>
       </table>
       <input type="hidden" name="old_section" value="<?php echo $row_rs_image['section'] ?>">
       <input type="hidden" name="old_file_name" value="<?php echo $row_rs_image['file_name'] ?>">
       <input type="hidden" name="image_id" value="<?php echo $row_rs_image['image_id'] ?>">
       <input type="hidden" name="MM_update" value="form1">
    </form>   </td>
  </tr>
</table>
</body>
</html>

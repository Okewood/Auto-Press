<?php require_once('../Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
session_start();
if(!isset($_SESSION['user_name'])) {
	header('Location: admin.php');
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  //specific image
  if(!empty($_FILES['userfile']['name']))
  	$file_name = $_FILES['userfile']['name']; 
  if(!empty($_POST['file_name']))
	$file_name = (strtoupper(substr($_POST['file_name'],0,-4)=='.JPG') ? substr($_POST['file_name'],0,-4).'.jpg' : $_POST['file_name'].'.jpg');
  if(file_exists('../images/'.$file_name)) {
  	$query = "SELECT sections.name AS section, categories.name AS category, DATE_FORMAT(categories.date, '%d-%m-%Y') AS date, images.title FROM images, categories, sections WHERE images.category_id=categories.category_id AND images.section_id=sections.section_id AND images.file_name='".$file_name."'";
  	$result = mysql_query($query, $connAutoPress) or die;
	$row = mysql_fetch_assoc($result);
	if(mysql_num_rows($result)!=0) $feedback = 'Problem: an image file called "'.$file_name.'" was used for '.$row['section'].', '.$row['category'].' '.$row['date'].', '.$row['title'];
  } else {
	$feedback = upload_jpeg('../temp/', '../images/', $file_name, 0);
  }
  if(empty($_FILES['userfile']['name'])) {
  	$feedback = 'Please select an image file to upload';
  }
  //write to table
  if(!$feedback) {
	$_SESSION['section_id'] = $_POST['section_id'];
  	$_SESSION['category_id'] = $_POST['category_id'];
	$frame_size = addslashes($_POST['frame_size']);
  	$picture_size = addslashes($_POST['picture_size']);
	$insertSQL = sprintf("INSERT INTO images (image_id, section_id, category_id, title, sub_title, frame_size, picture_size, file_name, keywords, display) VALUES (NULL, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['section_id'], "int"),
                       GetSQLValueString($_POST['category_id'], "int"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['sub_title'], "text"),
                       GetSQLValueString($_POST['frame_size'], "text"),
                       GetSQLValueString($_POST['picture_size'], "text"),
                       GetSQLValueString($file_name, "text"),
                       GetSQLValueString(strtoupper($_POST['keywords']), "text"),
                       GetSQLValueString($_POST['display'], "text"));

	mysql_select_db($database_connAutoPress, $connAutoPress);
	$Result1 = mysql_query($insertSQL, $connAutoPress) or die;
  }  
  if(!$feedback) {
	  //event image
	  if(!empty($_FILES['userfile2']['name'])) {
  		$file_name = 'header_'.$_POST['section_id'].'_'.$_POST['category_id'].'.jpg'; 
		$feedback = upload_header('../temp/', '../images/', $file_name, 0);
	  }
  }
  if(!$feedback) {
	$insertGoTo = "admin.php";
	if (isset($_SERVER['QUERY_STRING'])) {
   		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
	    $insertGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location: %s", $insertGoTo));
  }
}

mysql_select_db($database_connAutoPress, $connAutoPress);
$query_rs_sections = "SELECT * FROM sections WHERE 1";
$rs_sections = mysql_query($query_rs_sections, $connAutoPress) or die;
$row_rs_sections = mysql_fetch_assoc($rs_sections);
$totalRows_rs_sections = mysql_num_rows($rs_sections);

$query_rs_categories = "SELECT sections.name AS section, DATE_FORMAT(categories.date, '%d-%m-%Y') AS date, categories.category_id, categories.name AS category FROM categories LEFT JOIN sections USING (section_id) WHERE 1 ORDER BY sections.section_id ASC, categories.date DESC";
$rs_categories = mysql_query($query_rs_categories, $connAutoPress) or die;
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
function ZZZdisableEnterKey(e) {
     var key;      
     if(window.event)
          key = window.event.keyCode; //IE
     else
          key = e.which; //firefox      
     return (key != 13);
}
function disableEnterKey(e) {
     var key;      
     if(window.event) {
          key = window.event.keyCode; //IE
     } else {
          key = e.which; //firefox      
     }
	 if(key==13) {
	 	key=9;
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
    <td>&nbsp;</td>
    <td><div align="center"><a href="admin.php"><img src="../design/btnReturn.gif" width="35" height="35" border="0"></a></div></td>
  </tr>
  <tr>
   <td colspan="2">
     <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
       <table align="center" id="text">
         <tr valign="baseline">
           <td colspan="2" align="left" nowrap><?php echo (isset($feedback) ? '<span id="warning">'.$feedback.'</span>' : '&nbsp;'); ?></td>
          </tr>
         <tr valign="baseline">
           <td nowrap align="right">Section:</td>
           <td><select name="section_id" id="section_id">
             <?php do { ?>
             <option value="<?php echo $row_rs_sections['section_id']?>"<?php if(isset($_SESSION['section_id']) && $_SESSION['section_id']==$row_rs_sections['section_id']) echo " selected" ?>><?php echo $row_rs_sections['name']?></option>
             <?php } while ($row_rs_sections = mysql_fetch_assoc($rs_sections));
				  $rows = mysql_num_rows($rs_sections);
				  if($rows > 0) {
				      mysql_data_seek($rs_sections, 0);
					  $row_rs_sections = mysql_fetch_assoc($rs_sections);
				  }
			  ?>
           </select></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Event:</td>
           <td><select name="category_id" id="category_id">
             <?php do { ?>
             <option value="<?php echo $row_rs_categories['category_id']?>"<?php if(isset($_SESSION['category_id']) && $_SESSION['category_id']==$row_rs_categories['category_id']) echo " selected" ?>><?php echo $row_rs_categories['section'].': '.$row_rs_categories['category'].' '.$row_rs_categories['date']; ?></option>
             <?php } while ($row_rs_categories = mysql_fetch_assoc($rs_categories));
				  $rows = mysql_num_rows($rs_categories);
				  if($rows > 0) {
				      mysql_data_seek($rs_categories, 0);
					  $row_rs_categories = mysql_fetch_assoc($rs_categories);
				  }
			  ?>
           </select>&nbsp;<a href="cat_list.php"><img src="button_add.png" width="11" height="13" border="0"></a></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Picture title:</td>
           <td><input type="text" name="title" id="picture_title" value="<?php if(isset($_POST['title'])) echo $_POST['title']; ?>" size="100" onKeyDown="if (window.event.keyCode==13) window.event.keyCode=9;"></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Sub title:</td>
           <td><input name="sub_title" type="text" id="sub_title" value="<?php if(isset($_POST['sub_title'])) echo $_POST['sub_title']; ?>" size="100" onKeyDown="if (window.event.keyCode==13) window.event.keyCode=9;"></td>
         </tr>
         <tr valign="top">
           <td align="right" nowrap>Frame size:</td>
           <td><textarea name="frame_size" cols="25" rows="2" id="frame_size"><?php echo (isset($_POST['frame_size']) ? stripslashes($_POST['frame_size']) : '500 x 580mm') ?></textarea></td>
         </tr>
         <tr valign="top">
           <td align="right" nowrap>Picture size: </td>
           <td><textarea name="picture_size" cols="25" rows="2" id="picture_size"><?php echo (isset($_POST['picture_size']) ? stripslashes($_POST['picture_size']) : '210 x 297mm') ?></textarea></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Keywords:</td>
           <td><input type="text" name="keywords" value="<?php if(isset($_POST['keywords'])) echo $_POST['keywords']; ?>" size="100" onKeyDown="if (window.event.keyCode==13) window.event.keyCode=9;"></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Display:</td>
           <td>             <p>
               <label>
               <input name="display" type="radio" value="TRUE" id="noborder" checked>
               <label>
               <input type="radio" name="display" value="FALSE" id="noborder">
  False</label>
               <br>
               <br>
            </p></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">File:</td>
           <td><input name "MAX_FILE_SIZE" type="hidden" value="10000000">
		   <input name="userfile" type="file" id="userfile" size="85"></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">File name:</td>
           <td><input type="text" name="file_name" value="" size="32"> .jpg (leave this blank to retain original filename) </td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">Event image (658x356):</td>
           <td><input name="userfile2" type="file" id="userfile2" size="85"></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">&nbsp;</td>
           <td>This image does not have to be the same one as detailed above and can be<br>
            replaced at any time by uploading a new file from any of this event's pages. <br></td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr valign="baseline">
           <td nowrap align="right">&nbsp;</td>
           <td><input name="submit" type="submit" class="inputbutton" id="submit" value="Insert record"></td>
         </tr>
       </table>
       <input type="hidden" name="image_id" value="">
       <input type="hidden" name="MM_insert" value="form1">
    </form>   </td>
  </tr>
</table>
<script type="text/javascript">
<!--
document.getElementById('picture_title').focus();
//-->
</script>
</body>
</html>

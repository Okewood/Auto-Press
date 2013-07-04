<?php require_once('../Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
session_start();
require_once('functions.php');
include('../classes/class_email.php');
$em = new email;
if(!isset($_SESSION['user_name'])) {
	header('Location: index.php');
}
if(isset($_POST['Submit'])) {
  $date = $_POST['cat_year'].'-'.$_POST['cat_month'].'-'.$_POST['cat_day'];
  $query = sprintf("INSERT INTO categories VALUES(NULL, %s, '%s', '%s', '%s')",$_POST['section_id'],$_POST['name'],$date,$_POST['notes']);
  $result = mysql_query($query);
  //get category_id
  $query = "SELECT category_id FROM categories WHERE 1 ORDER BY category_id DESC LIMIT 1";
  $result = mysql_query($query);
  $category_id = mysql_result($result, 0, "category_id");
  $message = 'The following event title has been added: '.$_POST['name'].', '.$_POST['cat_day'].'/'.$_POST['cat_month'].'/'.$_POST['cat_year'].".\n\n"
	  ."Files required:-\n\n"
	  .' design/es_'.strtolower(substr($_POST['name'],0,5)).'_'.$date.".gif (use hdgSmall.png font size 12)\n\n"
	  .' design/el_'.strtolower(substr($_POST['name'],0,5)).'_'.$date.".gif (use hdgLarge.png font size 14)\n\n"
	  .'Change link text for latest event in menu (javascript/menu2.js) to: photo_thumb.php?section_id='.$_POST['section_id'].'&category_id='.$category_id;
	  $to = 'colin@okewoodimagery.com';
	  $subject = 'Auto-Press: new event title';
	  $from = 'info@auto-press.com';
	  $cc = 'rod@auto-press.com';
  $em->send_email($to,$subject,$message,$from,$cc);
  //mail('colin@okewoodimagery.com','Auto-Press: new event title',$message,"From:info@auto-press.com\r\nCc:rod@auto-press.com\n\n");
  header("Location: cat_list.php");
  exit;
}
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
<!--Fireworks MX 2004 Dreamweaver MX 2004 target.  Created Mon Sep 06 15:39:57 GMT+0100 (GMT Daylight Time) 2004-->
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
   <td height="65">
     <span class="title"><img src="../design/logosmall.gif" width="300" height="65"></span>     </td>
   <td><div align="center"><strong><img src="../design/t_administration.gif" width="150" height="13">&nbsp;</strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><a href="admin.php"><img src="../design/btnReturn.gif" width="35" height="35" border="0"></a></div></td>
  </tr>
  <tr valign="top">
   <td colspan="2">  
     <div align="right"><br>
      </div>
     <form name="form1" method="post" action="cat_add.php">
       <table width="300" border="1" align="center" cellpadding="3" cellspacing="3" id="text">
       <tr bordercolor="#FFFFFF">
         <td colspan="2"><?php echo (isset($feedback) ? '<span id="warning">'.$feedback.'</span>' : '<strong>Add new Event . . .</strong>'); ?></td>
         </tr>
       <tr bordercolor="#FFFFFF">
         <td><div align="right">Section:</div></td>
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
       <tr bordercolor="#FFFFFF">
         <td><div align="right">Name:</div></td>
         <td><input name="name" type="text" id="name" size="100" <?php if(isset($_POST['Submit'])) echo (!empty($_POST['name']) ? 'value="'.$_POST['name'].'"' : 'class="inputrequired" value=""'); else echo 'value="'.$row['name'].'"'; ?>></td>
       </tr>
       <tr bordercolor="#FFFFFF">
         <td><div align="right">Date:</div></td>
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
       </tr>
       <tr bordercolor="#FFFFFF">
         <td>Description:</td>
         <td><textarea name="notes" cols="75" rows="5" id="notes"></textarea></td>
       </tr>
       <tr bordercolor="#FFFFFF">
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr bordercolor="#FFFFFF">
         <td>&nbsp;</td>
         <td><input name="Submit" type="submit" class="inputbutton" value="Submit"></td>
       </tr>
     </table>
   </form>   </td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript"><!--
if (document.form1.username) {
	document.form1.username.focus();
}
//--></script>

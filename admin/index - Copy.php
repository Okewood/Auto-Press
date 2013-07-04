<?php require_once('../Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
require_once('functions.php');
session_start();
if(isset($_GET['logout'])) {
	unset($HTTP_SESSION_VARS['user_id']);
	session_destroy();
}
if(isset($_POST['Submit'])) {
	if(isset($_POST['chkEmail']) && $_POST['chkEmail']=="yes") {
		$feedback = notify_password($_POST['email']);
	} 
	if(!isset($_POST['chkEmail'])) {
		$feedback = login($_POST['email'], $_POST['password']);
	}
	if(isset($_POST['chkAmend']) && $_POST['chkAmend']=="yes" && isset($_SESSION['user_name'])) {
		header('Location: user_amend.php');
		exit;
	}
}
if(isset($_SESSION['user_name'])) {
	header('Location: admin.php');
	exit;
}
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
   <td><div align="right"><strong><img src="../design/t_administration.gif" width="150" height="13">&nbsp;</strong></div></td>
  </tr>
  <tr>
   <td colspan="2">   <form name="form1" method="post" action="index.php">
     <table width="300" border="1" align="center" cellpadding="3" cellspacing="3" id="text">
       <tr bordercolor="#FFFFFF">
         <td colspan="2"><?php echo (isset($feedback) ? '<span id="warning">'.$feedback.'</span>' : '&nbsp;'); ?></td>
         </tr>
       <tr bordercolor="#FFFFFF">
         <td><div align="right">Email:</div></td>
         <td><input name="email" type="text" id="email" size="60" <?php if(isset($_POST['Submit'])) echo (!empty($_POST['email']) ? 'value="'.$_POST['email'].'"' : 'class="inputrequired" value=""'); else echo 'value=""'; ?>></td>
       </tr>
       <tr bordercolor="#FFFFFF">
         <td><div align="right">Password:</div></td>
         <td><input name="password" type="password" id="password" size="60" <?php if(isset($_POST['Submit'])) echo (!empty($_POST['password']) ? 'value="'.$_POST['password'].'"' : 'class="inputrequired" value=""'); else echo 'value=""'; ?>></td>
       </tr>
       <tr bordercolor="#FFFFFF">
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr bordercolor="#FFFFFF">
         <td colspan="2"><div align="right">Email me my password?:
                <input name="chkEmail" type="checkbox" id="noborder" value="yes" <?php if(isset($_POST['chkEmail'])) echo 'checked'; ?>>
         </div></td>
         </tr>
       <tr bordercolor="#FFFFFF">
         <td colspan="2"><div align="right">Change details/password: 
                <input name="chkAmend" type="checkbox" id="noborder" value="yes"<?php if(isset($_POST['chkAmend'])) echo 'checked'; ?>>
         </div></td>
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
if (document.form1.email) {
	document.form1.email.focus();
}
//--></script>

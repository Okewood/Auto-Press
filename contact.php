<?php session_start();
require_once('Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
include('classes/class_u_output.php');
$output = new output;
$head = '';
$body = '';
$output->html_top($head, $body);
$output->menu();
//=================================================================================================
?>
<div id="image" style="margin-left:auto; margin-right:auto; width:658px; padding-bottom:20px;">
	<img src="design/photos/contact.jpg" width="658" height="355" id="slide1">
</div>
<div id="text" style="margin-left:auto; margin-right:auto; width:658px;">
	<p class="para_header"><img src="design/titles/title_contactdetails.jpg"></p>
	<br>
	<img src="design/titles/title_sales.jpg"><br>
	To place an order email your requirements using this link: <a href="mailto:sales@auto-press.com">sales@auto-press.com</a><br>
	<br>
	<img src="design/titles/title_general.jpg"><br>
	For all other enquiries please use this link: <a href="mailto:info@auto-press.com">info@auto-press.com</a>
</div>
<?php
//================================================================================================= 
$output->html_bottom();
?>

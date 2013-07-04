<?php session_start();
require_once('Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
include('classes/class_u_output.php');
$output = new output;

//get page text
$query = "SELECT page_text FROM site_text WHERE identifier='latest update'";
$result = mysql_query($query, $connAutoPress) or die;
$latest_update_text = mysql_result($result,0);
	
$head = '';
$body = "onLoad=\"flvFTSS1('slide1',1000,5000,1,1,'design/photos/home1.jpg',0,'design/photos/home2.jpg',0,'design/photos/home3.jpg',0,'design/photos/home4.jpg',0,'design/photos/home5.jpg',0,'design/photos/home6.jpg',0);\"";
$output->html_top($head, $body);
$output->menu();
//=================================================================================================
?>
<div id="image" style="margin-left:auto; margin-right:auto; width:658px; padding-bottom:20px;">
	<img src="design/photos/home1.jpg" width="658" height="355" id="slide1">
</div>
<div id="text" style="margin-left:auto; margin-right:auto; width:658px;">
	<p class="para_header"><img src="design/titles/title_lastestupdate.jpg"></p>
	<?php echo $latest_update_text ?>
	<p class="para_header"><img src="design/titles/title_optimisedviewing.jpg"></p>
	This site is optimised for viewing with the latest browser updates and is best viewed using the full screen option, where available.
	<p class="para_header"><img src="design/titles/title_picturearchive.jpg"></p>
	Click on gallery to access the digital image archive of motorsport and marine subjects. Many additional images from
	each event are available on request. Access price and order details using the information button. Bespoke 
	commissions undertaken, please email your requirements.
	<p class="dark_grey" style="text-align:right; padding-top:12px;">&copy; Rod Laws <?php echo date('Y') ?></p>
</div>
<?php
//================================================================================================= 
$output->html_bottom();
?>

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
	<img src="design/photos/info.jpg" width="658" height="355" id="slide1">
</div>
<div id="text" style="margin-left:auto; margin-right:auto; width:658px;">
	<p class="para_header"><img src="design/titles/title_ordering.jpg"></p>
	To place an order please email your requirements, including the image reference number and your
contact details using this link: <a href="mailto:sales@auto-press.com">sales@auto-press.com</a>
	<p class="para_header"><img src="design/titles/title_prices.jpg"></p>
	Prices exclude postage and packaging. Larger print sizes available upon request.<br>
	<br>
	<br>
	<table align="center" cellpadding="3"  cellspacing="0">
	  <tr>
		<td width="150" class="yellow">297mm x 210mm </td>
		<td width="40">&nbsp;</td>
		<td align="right" width="25">&pound;</td>
		<td align="right">30.00</td>
	  </tr>
	  <tr>
		<td class="yellow">457mm x 305mm </td>
		<td>&nbsp;</td>
		<td align="right">&pound;</td>
		<td align="right">50.00</td>
	  </tr>
	  <tr>
		<td class="yellow">610mm x 457mm </td>
		<td>&nbsp;</td>
		<td align="right">&pound;</td>
		<td align="right">100.00</td>
	  </tr>
	  <tr>
		<td class="yellow">838mm x 584mm </td>
		<td>&nbsp;</td>
		<td align="right">&pound;</td>
		<td align="right">150.00</td>
	  </tr>
	</table>
	<p class="para_header"><img src="design/titles/title_copyright.jpg"></p>
	All photographs displayed on this internet site are copyright Rod Laws. All rights reserved . Any copying, reproduction, retransmission, or storing in a retrieval system of any of the images in whole or partially is prohibited without the prior written permission of Rod Laws.
	<p class="para_header"><img src="design/titles/title_termsandconditions.jpg"></p>
	Any contractual relationships shall be subject to the laws of England and Wales.
</div>
<?php
//================================================================================================= 
$output->html_bottom();
?>

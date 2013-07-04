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
	<img src="design/photos/search.jpg" width="658" height="355" id="slide1">
</div>
<div id="text" style="margin-left:auto; margin-right:auto; width:658px;">
	<p class="para_header"><img src="design/titles/title_searchtips.jpg"></p>
    <form name="form1" method="post" action="search_thumb.php">
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>&nbsp;</td>
		<td colspan="2" class="white" style="padding-bottom:3px;"><img src="design/titles/title_keywords.jpg"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td colspan="2">Search for a specific car make, model and/or driver.
		  Separate what you are searching for with commas, 


 eg &quot;Ferrari, Raikkonen&quot; or eg &quot;Kimi, Raikkonen&quot; and choose the relevant search option below.</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td style="width:50px;"><input name="search_type" type="radio" id="noborder" value="inc" checked></td>
		<td colspan="2" class="white"><img src="design/titles/title_inclusivesearch.jpg"></td>
	  </tr>
	  <tr>
		<td> </td>
		<td colspan="2"> Locate images that include anything you searched for, eg Ferrari, Raikkonen will display any Ferrari and any Raikkonen images.</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
		<td><input name="search_type" type="radio" id="noborder" value="exc" <?php echo (isset($_SESSION['search_type']) && $_SESSION['search_type']=='exc' ? 'checked' : '') ?>></td>
		<td colspan="2" class="white"><img src="design/titles/title_exclusivesearch.jpg"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td colspan="2"> Locate images that include everything you searched for, eg Ferrari, Raikkonen will display only the images of a Ferrari driven by Raikkonen.</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td class="yellow"><table border="0" cellspacing="0" cellpadding="3">
		  <tr>
			<td><img src="design/titles/title_search.jpg"></td>
			<td><input name="search_field" id="search_field" type="text" size="50" value="<?php echo (isset($_SESSION['search_field']) ? $_SESSION['search_field'] : ''); ?>" onKeyPress="checkEnter(event)"></td>
			<td><a href="Javascript:;" onClick="document.form1.submit(); return false;"><img src="design/buttons/btn_go_off.jpg" onMouseOver="this.src='design/buttons/btn_go_on.jpg'" onMouseOut="this.src='design/buttons/btn_go_off.jpg'" border="0"></a></td>
		  </tr>
		</table></td>
		<td></td>
	  </tr>
	</table>
	</form>
</div>
<?php
//================================================================================================= 
$output->html_bottom();
?>

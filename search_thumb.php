<?php session_start();
require_once('Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
include('classes/class_u_output.php');
$output = new output;

$arr = array('%','<','>',';','"','INSERT','insert','UPDATE','update'); 
foreach($arr as $key => $search_needle) { 
  if(stristr($_REQUEST['search_field'], $search_needle) != FALSE) { 
   	unset($_REQUEST['search_field']);
	header('Location: search.php');
	exit;
  } 
}

$returnURL = 'search.php';
$heading = 't_search.gif';
$str = (isset($_REQUEST['search_field']) ? $_REQUEST['search_field'] : (isset($_SESSION['search_field']) ? $_SESSION['search_field'] : $str));
$_SESSION['search_field'] = $str;
$_SESSION['search_type'] = $_REQUEST['search_type'];

//Remove spaces
$str = str_replace(' ','',trim($str));
//split search strings into individual values
if($_REQUEST['search_type']=='inc') {
	$OR_keywords = '0';
	$OR_expl = explode(',',$str);
	//create MySQL search strings
	foreach($OR_expl as $value) {
		if(!empty($value)) {
			$OR_keywords .= (!empty($value) ? ' OR CONCAT(" ",UPPER(title)," ") LIKE "% '.strtoupper($value).' %"' : '');
			$OR_keywords .= (!empty($value) ? ' OR CONCAT(" ",UPPER(sub_title)," ") LIKE "% '.strtoupper($value).' %"' : '');
		}
	}
	$searchstring = $OR_keywords;
} else {
	$AND_keywords = '1';
	$AND_expl = explode(',',$str);
	//create MySQL search strings
	foreach($AND_expl as $value) {
		if(!empty($value)) {
			$AND_keywords .= (!empty($value) ? ' AND (CONCAT(" ",UPPER(title)," ") LIKE "% '.strtoupper($value).' %"' : '');
			$AND_keywords .= (!empty($value) ? ' OR CONCAT(" ",UPPER(sub_title)," ") LIKE "% '.strtoupper($value).' %")' : '');
		}
	}
	$searchstring = $AND_keywords;
}
$query = 'SELECT * from images WHERE '.$searchstring.' ORDER BY title';
$result = mysql_query($query, $connAutoPress) or die;
$row = mysql_fetch_assoc($result);
$totalRows = mysql_num_rows($result);
$giftext = $output->image_root.($totalRows!=0 ? 'design/th_searchresults.gif' : 'design/t_nopicturesfound.gif');
$image = ($totalRows==0 ? 'H003.jpg' : $row['file_name']);

$head = '';
$body = '';
$output->html_top($head, $body);
$output->menu();
//=================================================================================================
?>
<table cellspacing="0" cellpadding="0" style="margin-left:auto; margin-right:auto; padding:20px 0px 20px 0px; width:658px;">
  <tr>
    <td style="width:258px; vertical-align:top;"><img src="inc_thumb.php?filename=<?php echo $output->image_root.($totalRows ? 'images/'.$row['file_name'] : 'design/photos/search_noresult.jpg') ?>&size=150px"></td>
    <td style="width:400px;">
    <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td style="width:50px;">&nbsp;</td>
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
	    <td style="padding-right:10px;"><input name="search_type" type="radio" id="noborder" value="inc" checked></td>
		<td colspan="2" class="white"><img src="design/titles/title_inclusivesearch.jpg"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td colspan="2"> Locate images that include anything you searched for, eg Ferrari, Raikkonen will display any Ferrari and any Raikkonen images.</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
		<td style="padding-right:10px;"><input name="search_type" type="radio" id="noborder" value="exc" <?php echo (isset($_SESSION['search_type']) && $_SESSION['search_type']=='exc' ? 'checked' : '') ?>></td>
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
			<td><img src="design/titles/title_newsearch.jpg"></td>
			<td><input name="search_field" id="search_field" type="text" size="50" value="<?php echo (isset($_SESSION['search_field']) ? $_SESSION['search_field'] : ''); ?>" onKeyPress="checkEnter(event)"></td>
			<td><a href="Javascript:;" onClick="document.form1.submit(); return false;"><img src="design/buttons/btn_go_off.jpg" onMouseOver="this.src='design/buttons/btn_go_on.jpg'" onMouseOut="this.src='design/buttons/btn_go_off.jpg'" border="0"></a></td>
		  </tr>
		</table></td>
		<td></td>
	  </tr>
	</table>
	</form></td>
  </tr>
</table>
<div id="text" style="margin-left:auto; margin-right:auto; width:658px;">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td style="padding-bottom:10px; border-bottom:1px solid #FFFF00;" class="yellow_header"><img src="design/titles/title_searchresults.jpg"></td>
			<td style="padding-bottom:10px; border-bottom:1px solid #FFFF00; text-align:right; vertical-align:bottom;">&nbsp;</td>
		</tr>
        <tr>
          <td colspan="2" align="center"><?php
			  if(isset($image_array)) unset($image_array); 
			  if($totalRows!=0) { //i.e. records found 
			  	if($_REQUEST['section_id']!=1) { 
				$title = $row['category'].', '.$row['format_date']; ?>
		  	    <?php }
				$cellcounter = 0; 
				$image_counter = 0; ?>
			    <table width="100%" cellpadding="0" cellspacing="0">
				  <br><br>
				  <? do { //loop through all records ?>
				      <tr>
					    <?php do { 
							$title = $row['title']." ".(strlen($row['title']) < 19 ? str_repeat("&nbsp;",35-strlen($row['title'])) : ""); ?>
							<td style="text-align:center; width:160px;"><a href="search_large.php?image_array_no=<?php echo $image_counter ?>"><img src="<?php echo $output->image_root ?>inc_thumb.php?size=160&filename=images/<?php echo $row['file_name'] ?>" border="0"></a><br>
	<a href="search_large.php?image_array_no=<?php echo $image_counter ?>"><br><span class="white"><?php echo wordwrap($title,18,'<br>');?></span></a></td>							
							<?php if($cellcounter<2) echo '<td><img src="'.$output->image_root.'design/spacer.gif" width="59"></td>'; ?>							
							<?php $image_array[$image_counter] = $row['image_id'];
							$cellcounter+=1;
							$image_counter+=1;
						} while ($cellcounter<3 && $row = mysql_fetch_assoc($result)); 
						$cellcounter = 0; ?>
				      </tr>
				      <tr><td>&nbsp;</td></tr>
				    <?php } while ($row = mysql_fetch_assoc($result)); //end of loop through all records 
					$_SESSION['image_array'] = $image_array; ?>
	        </table>
          <?php } else {
		  	echo "<p style='text-align:left; padding-top:15px'>No images matched your search criteria. To refine your search separate what you are searching for with commas, eg if you want to search for Ford GT40s type Ford, GT40 and select the 'Exclusive search option'. This will display only Ford GT40s</p>";
		  } //end of if records found ?></td>
        </tr>
    </table>
</div>
<?php
//================================================================================================= 
$output->html_bottom();
?>

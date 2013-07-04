<?php session_start();
require_once('Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
include('classes/class_u_output.php');
$output = new output;

$heading = 't_search.gif';
$image_id = $_SESSION['image_array'][$_REQUEST['image_array_no']];
$query = "SELECT images.*, categories.name AS category, DATE_FORMAT(categories.date,'%d.%m.%Y') AS cat_date FROM images LEFT JOIN categories USING (category_id) WHERE image_id = ".$image_id;
$result = mysql_query($query, $connAutoPress) or die;
$row = mysql_fetch_assoc($result);

$head = '';
$body = '';
$output->html_top($head, $body);
//=================================================================================================
?>
	<div id="navigation" style="margin-left:auto; margin-right:auto; width:540px;">
	  <table cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
		  <td class="site_header" style="vertical-align:bottom;"><img src="design/titles/title_autopress40.jpg" width="200" height="50"></td>
		  <td style="text-align:right; vertical-align:bottom; padding-bottom:3px;"><table cellspacing="0" cellpadding="0" style="margin-left:auto;">
			<tr>
			  <td colspan="6" onMouseOver="document.getElementById('gallery_sub').style.visibility='hidden';">&nbsp;</td>
			</tr>
			<tr>
			  <td> 
			  <a href="index.php"><?php if(stristr($_SERVER['PHP_SELF'],'index')) { ?><img src="design/buttons/btn_home_on.jpg" onMouseOver="document.getElementById('gallery_sub').style.visibility='hidden';" border="0"><?php } else { ?><img src="design/buttons/btn_home_off.jpg" onMouseOver="this.src='design/buttons/btn_home_on.jpg'; document.getElementById('gallery_sub').style.visibility='hidden';" onMouseOut="this.src='design/buttons/btn_home_off.jpg';" border="0"><?php } ?></a></td>
			  <td><?php if(stristr($_SERVER['PHP_SELF'],'gallery')) { ?><img src="design/buttons/btn_gallery_on.jpg" onMouseOver="document.getElementById('gallery_sub').style.visibility='visible';" border="0"><?php } else { ?><img src="design/buttons/btn_gallery_off.jpg" onMouseOver="this.src='design/buttons/btn_gallery_on.jpg'; document.getElementById('gallery_sub').style.visibility='visible';" onMouseOut="this.src='design/buttons/btn_gallery_off.jpg';" border="0"><?php } ?></td>
			  <td><a href="info.php"><?php if(stristr($_SERVER['PHP_SELF'],'info')) { ?><img src="design/buttons/btn_info_on.jpg" onMouseOver="document.getElementById('gallery_sub').style.visibility='hidden';" border="0"><?php } else { ?><img src="design/buttons/btn_info_off.jpg" onMouseOver="this.src='design/buttons/btn_info_on.jpg';  document.getElementById('gallery_sub').style.visibility='hidden'" onMouseOut="this.src='design/buttons/btn_info_off.jpg'" border="0"><?php } ?></a></td>
			  <td><a href="search.php"><?php if(stristr($_SERVER['PHP_SELF'],'search')) { ?><img src="design/buttons/btn_search_on.jpg" onMouseOver="document.getElementById('gallery_sub').style.visibility='hidden';" border="0"><?php } else { ?><img src="design/buttons/btn_search_off.jpg" onMouseOver="this.src='design/buttons/btn_search_on.jpg';  document.getElementById('gallery_sub').style.visibility='hidden'" onMouseOut="this.src='design/buttons/btn_search_off.jpg'" border="0"><?php } ?></a></td>
			  <td><a href="contact.php"><?php if(stristr($_SERVER['PHP_SELF'],'contact')) { ?><img src="design/buttons/btn_contact_on.jpg" onMouseOver="document.getElementById('gallery_sub').style.visibility='hidden';" border="0"><?php } else { ?><img src="design/buttons/btn_contact_off.jpg" onMouseOver="this.src='design/buttons/btn_contact_on.jpg';  document.getElementById('gallery_sub').style.visibility='hidden'" onMouseOut="this.src='design/buttons/btn_contact_off.jpg'" border="0"><?php } ?></a></td>
			  <td><a href="links.php"><?php if(stristr($_SERVER['PHP_SELF'],'links')) { ?><img src="design/buttons/btn_links_on.jpg" onMouseOver="document.getElementById('gallery_sub').style.visibility='hidden';" border="0"><?php } else { ?><img src="design/buttons/btn_links_off.jpg" onMouseOver="this.src='design/buttons/btn_links_on.jpg';  document.getElementById('gallery_sub').style.visibility='hidden'" onMouseOut="this.src='design/buttons/btn_links_off.jpg'" border="0"><?php } ?></a></td>
			</tr>
		  </table></td>
		</tr>
	  </table>
	</div>
	<div id="gallery_sub" style="margin-left:auto; margin-right:auto; width:540px; visibility:hidden; text-align:right;">
		<div><a href="gallery_contents.php?section_id=2"><img src="design/buttons/btn_motorsport_off.jpg" onMouseOver="this.src='design/buttons/btn_motorsport_on.jpg'" onMouseOut="this.src='design/buttons/btn_motorsport_off.jpg'" border="0"></a>
		<img src="design/buttons/sub_pipe.jpg">
		<a href="gallery_contents.php?section_id=3"><img src="design/buttons/btn_goodwood_off.jpg" onMouseOver="this.src='design/buttons/btn_goodwood_on.jpg'"  onMouseOut="this.src='design/buttons/btn_goodwood_off.jpg'" border="0"></a>
		<img src="design/buttons/sub_pipe.jpg">
		<a href="gallery_contents.php?section_id=4"><img src="design/buttons/btn_marine_off.jpg" onMouseOver="this.src='design/buttons/btn_marine_on.jpg'" onMouseOut="this.src='design/buttons/btn_marine_off.jpg'" border="0"></a>
		<img src="design/buttons/sub_pipe.jpg">
		<a href="gallery_thumb.php?section_id=<?php echo $output->latest_event('section_id') ?>&category_id=<?php echo $output->latest_event('category_id') ?>"><img src="design/buttons/btn_latestevent_off.jpg" onMouseOver="this.src='design/buttons/btn_latestevent_on.jpg'" onMouseOut="this.src='design/buttons/btn_latestevent_off.jpg'" border="0"></a>
		</div>
	</div>
<div id="image" align="center" style="padding-bottom:20px; padding-top:15px">
	<img src="<?php echo $output->image_root ?>images/<?php echo $row['file_name'] ?>">
</div>
<div id="text" style="margin-left:auto; margin-right:auto; width:540px;">
	<table cellpadding="0" cellspacing="0" style="margin-left:auto; margin-right:auto; width:100%;">
		<tr>
			<td style="padding-bottom:10px; border-bottom:1px solid #FFFF00;" class="yellow_header"><img src="design/titles/title_imagedetails.jpg"></td>
			<td style="padding-bottom:10px; border-bottom:1px solid #FFFF00; text-align:right; vertical-align:bottom;"><a href="search_thumb.php"><img src="design/buttons/btn_back.jpg" border="0"></a> <a href="search_large.php?image_array_no=<?php echo ($_REQUEST['image_array_no']==0 ? (count($_SESSION['image_array'])-1) : $_REQUEST['image_array_no']-1 ); ?>"><img src="design/buttons/btn_previous.jpg" border="0"></a> <a href="search_large.php?image_array_no=<?php echo ($_REQUEST['image_array_no']==(count($_SESSION['image_array'])-1) ? 0 : $_REQUEST['image_array_no']+1 ); ?>"><img src="design/buttons/btn_next.jpg" border="0"></a></td>
		</tr>
		<tr>
			<td style="padding-top:10px;" class="white"><img src="design/titles/title_title.jpg"></td>
			<td style="padding-top:10px;"><?php echo $row['title'] ?></td>
		</tr>
		<tr align="left">
			<td style="padding-top:10px;" class="white"><img src="design/titles/title_description.jpg"></td>
			<td style="padding-top:10px;"><?php echo $row['sub_title'] ?></td>
		</tr>
		<tr align="left">
			<td style="padding-top:10px;" class="white"><img src="design/titles/title_event.jpg"></td>
			<td style="padding-top:10px;"><?php echo $row['category'].(substr_count($row['category'],".")==2 ? ' - ' : ' ').$row['cat_date'] ?></td>
		</tr>
		<tr align="left">
			<td style="padding-top:10px;" class="white"><img src="design/titles/title_imagereference.jpg"></td>
			<td style="padding-top:10px;"><?php echo substr($row['file_name'],0,-4) ?></td>		</tr>
    </table>
</div>
<?php
//================================================================================================= 
$output->html_bottom();
?>

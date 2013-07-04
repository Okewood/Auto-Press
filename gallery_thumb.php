<?php session_start();
require_once('Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
include('classes/class_u_output.php');
$output = new output;

switch($_REQUEST['section_id']) {
	case 1: 
		$heading = 'th_artphotos.gif';
		$image = (file_exists($output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$_REQUEST['category_id'].'.jpg') ? $output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$_REQUEST['category_id'].'.jpg' : 'ArtPhotos.jpg');
		$query = 'SELECT * from images WHERE section_id=1 ORDER BY file_name';
		$returnURL = 'index.php';
		break;
	case 2: 
		$heading = 'title_motorsportimagearchive.jpg';
		$image = (file_exists($output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$_REQUEST['category_id'].'.jpg') ? $output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$_REQUEST['category_id'].'.jpg' : $output->image_root.'design/photos/home1.jpg');
		$returnURL = 'photo_contents.php?section_id='.$_REQUEST['section_id'];
		break;
	case 3:
		$heading = 'title_goodwoodimagearchive.jpg';
		$image = (file_exists($output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$_REQUEST['category_id'].'.jpg') ? $output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$_REQUEST['category_id'].'.jpg' : $output->image_root.'design/photos/home2.jpg');
		$returnURL = 'photo_contents.php?section_id='.$_REQUEST['section_id'];
		break;
	case 4:
		$heading = 'title_marineimagearchive.jpg';
		$image = (file_exists($output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$_REQUEST['category_id'].'.jpg') ? $output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$_REQUEST['category_id'].'.jpg' : $output->image_root.'design/photos/home5.jpg');
		$returnURL = 'photo_contents.php?section_id='.$_REQUEST['section_id'];
		break;
}
//get images and event details
$query = "SELECT images.*, categories.name AS category, DATE_FORMAT(categories.date,'%d.%m.%Y') AS format_date, categories.date, categories.notes FROM images LEFT JOIN categories USING (category_id) WHERE images.section_id = ".$_REQUEST['section_id']." AND images.category_id=".$_REQUEST['category_id']." ORDER BY file_name";
$rs_event = mysql_query($query, $connAutoPress) or die;
$row_event = mysql_fetch_assoc($rs_event);

//get thumbnail details;
$result = mysql_query($query, $connAutoPress) or die;
$row = mysql_fetch_assoc($result);
$totalRows = mysql_num_rows($result);
$first_pic = ($totalRows==0 ? 'latest_event_pic.gif' : $row['file_name']);

$head = '';
$body = '';
$output->html_top($head, $body);
$output->menu();
//=================================================================================================
?>
<div id="image" style="margin-left:auto; margin-right:auto; width:658px; padding-bottom:20px;">
	<img src="<?php echo $image ?>" width="658" height="355" id="slide1">
</div>
<div id="text" style="margin-left:auto; margin-right:auto; width:658px;">
	<table cellspacing="0" cellpadding="0" style="margin-left:auto; margin-right:auto; width:658px;">
		<tr>
			<td style="padding-bottom:10px; border-bottom:1px solid #FFFF00;" class="yellow_header"><img src="design/titles/<?php echo $heading ?>"></td>
			<td style="padding-bottom:10px; border-bottom:1px solid #FFFF00; text-align:right; vertical-align:bottom;"><a href="gallery_contents.php?section_id=<?php echo $_REQUEST['section_id'] ?>"><img src="design/buttons/btn_back.jpg" border="0"></a></td>
		</tr>
		  <tr>
			<td colspan="2"><table cellpadding="0" cellspacing="0" style="padding-top:20px;">
				<tr>
				  <td style="text-align:left; vertical-align:top;"><span class="para_header_sm"><?php echo $row_event['category'].' - '.$row_event['format_date'] ?></span><br>
					  <div style="text-align:left; padding-top:5px;"><?php echo $row_event['notes'] ?></div></td>
				</tr>
			  </table></td>
		  </tr>
	</table>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2" align="center" id="border_b"><?php
			  if(isset($image_array)) unset($image_array); 
			  if($totalRows!=0) { //i.e. records found 
			  	if($_REQUEST['section_id']!=1) { 
				$title = $row['category'].', '.$row['format_date']; ?>
		  	    <?php }
				$cellcounter = 0; 
				$image_counter = 0; ?>
			    <table width="658" cellpadding="0" cellspacing="0">
				  <br><br>
				  <? do { //loop through all records ?>
				      <tr>
					    <?php do { 
							$title = $row['title']." ".(strlen($row['title']) < 19 ? str_repeat("&nbsp;",35-strlen($row['title'])) : ""); ?>
							<td style="text-align:center; width:160px;"><a href="gallery_large.php?section_id=<?php echo $row['section_id']; ?>&category_id=<?php echo $row['category_id']; ?>&image_array_no=<?php echo $image_counter ?>"><img src="<?php echo $output->image_root ?>inc_thumb.php?size=160&filename=images/<?php echo $row['file_name'] ?>" border="0"></a><br>
	<a href="gallery_large.php?section_id=<?php echo $row['section_id']; ?>&category_id=<?php echo $row['category_id']; ?>&image_array_no=<?php echo $image_counter ?>"><br><span class="white"><?php echo wordwrap($title,18,'<br>');?></span></a></td>							
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
          <?php } //end of if records found ?>		  </td>
        </tr>
    </table>
</div>
<?php
//================================================================================================= 
$output->html_bottom();
?>

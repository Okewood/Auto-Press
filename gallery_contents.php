<?php session_start();
require_once('Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
include('classes/class_u_output.php');
$output = new output;

$query = "SELECT images.*, categories.name AS category, DATE_FORMAT(categories.date,'%d.%m.%Y') AS format_date, categories.date, categories.notes FROM images LEFT JOIN categories USING (category_id) WHERE images.section_id = ".$_REQUEST['section_id']." ORDER BY categories.date DESC, file_name";
$result = mysql_query($query, $connAutoPress) or die;
$row = mysql_fetch_assoc($result);
$totalRows = mysql_num_rows($result);

switch($_REQUEST['section_id']) {
	case 1:
		header('Location: gallery_thumb.php?section_id=1');
		break;
	case 2: 
		$text = 'Motorsport';
		$heading = 'title_motorsportimagearchive.jpg';
		$image = (file_exists($output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$row['category_id'].'.jpg') ? $output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$row['category_id'].'.jpg' : $output->image_root.'design/photos/home1.jpg');
		break;
	case 3:
		$text = 'Goodwood';
		$heading = 'title_goodwoodimagearchive.jpg';
		$image = (file_exists($output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$row['category_id'].'.jpg') ? $output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$row['category_id'].'.jpg' : $output->image_root.'design/photos/home2.jpg');
		break;
	case 4:
		$text = 'Marine';
		$heading = 'title_marineimagearchive.jpg';
		$image = (file_exists($output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$row['category_id'].'.jpg') ? $output->image_root.'images/header_'.$_REQUEST['section_id'].'_'.$row['category_id'].'.jpg' : $output->image_root.'design/photos/home5.jpg');
		break;
}

$_SESSION['menu_section'] = $text;

$head = '';
$body = '';
$output->html_top($head, $body);
$output->menu();
//=================================================================================================
?>
<div id="image" style="margin-left:auto; margin-right:auto; width:658px; padding-bottom:20px;">
	<img src="<?php echo $image ?>">
</div>
<div id="text" style="margin-left:auto; margin-right:auto; width:658px;">
	<p class="yellow_header" style="padding-bottom:10px; border-bottom:1px solid #FFFF00;"><img src="design/titles/<?php echo $heading ?>"></p>
	<table cellspacing="0" cellpadding="0" style="margin-left:auto; margin-right:auto; padding-top:25px;">
	<?php if($totalRows==0) { //check for records
		echo 'No pictures on file';
	} else {
	  $category_id = '';
	  do { 
	  	if($category_id != $row['category_id']) { //display loop ?>
		  <tr>
			<td><table cellpadding="0" cellspacing="0">
				<tr>
				  <td style="padding:10px 15px 15px 0px;"><a href="gallery_thumb.php?section_id=<?php echo $row['section_id']; ?>&category_id=<?php echo $row['category_id']; ?>"><img src="inc_thumb.php?size=160&filename=images/<?php echo $row['file_name'] ?>" border="0"></a></td>
				  <td style="padding:8px 0px 0px 0px; text-align:left; vertical-align:top;"><div style="text-align:justify"><a href="gallery_thumb.php?section_id=<?php echo $row['section_id']; ?>&category_id=<?php echo $row['category_id']; ?>"><?php $jpgtext = 'design/titles/es_'.strtolower(substr($row['category'],0,5)).'_'.$row['date'].'.jpg'; echo (file_exists($jpgtext) ? '<img src="'.$jpgtext.'" border="0">' : '<span class="para_header">'.$row['category'].' - '.$row['format_date'] ).'</span>'; ?></a><br>
					  <?php echo $row['notes'] ?></div></td>
				</tr>
			  </table>
				<div align="justify"><a href="gallery_thumb.php?section_id=<?php echo $row['section_id']; ?>&category_id=<?php echo $row['category_id']; ?>"> </a><span id="small_text"><br>
			  </span> </div></td>
		  </tr>
		  <?php } //end of display loop
	  $category_id = $row['category_id'];
	  } while($row = mysql_fetch_assoc($result)); 
	  } ?>
	</table>
</div>
<?php
//================================================================================================= 
$output->html_bottom();
?>

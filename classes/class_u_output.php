<?php class output {

var $width 				= 658;
var $height 			= 600;
var $html_title			= 'Autopress';
var $html_description	= 'Rod Laws at auto-press.com offers an Image Archive featuring photographs of contemporary and historic motorsport subjects. Framed/unframed copies of these photographs available to purchase.';
var $html_keywords		= 'Rod Laws, Auto Press, auto-press, auto-press.com, motorsport, photography, photographs, photos, photographer, motorsport photos for sale, pictures, framed, images, cars, racing cars, yacht, powerboats, Cowes, TGP, F1, historic car, revival, Goodwood.';
var $site_root			= 'http://www.autopress.com/';
var $image_root			= '';

//=======================================================================================================
function html_top($head='', $body='') { ?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<title><?php echo $this->html_title; ?></title>
	<meta name="description" content="<?php echo $this->html_description; ?>">
	<meta name="keywords" content="<?php echo $this->html_keywords; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="stylesheets/ap.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" language="JavaScript1.2" src="javascript/javascript_fns.js"></script>
	<?php if(!empty($head)) echo $head; ?>
	</head>
	
	<body <?php if(!empty($body)) echo $body ?>>
<?php } 
//=======================================================================================================
function menu() { ?>
	<div id="navigation" style="margin-left:auto; margin-right:auto; width:658px;">
	  <table cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
		  <td class="site_header" style="vertical-align:bottom;"><img src="design/titles/title_autopress.jpg" width="200" height="50"></td>
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
	<div id="gallery_sub" style="margin-left:auto; margin-right:auto; width:658px; visibility:hidden; text-align:right;">
		<div><a href="gallery_contents.php?section_id=2"><img src="design/buttons/btn_motorsport_off.jpg" onMouseOver="this.src='design/buttons/btn_motorsport_on.jpg'" onMouseOut="this.src='design/buttons/btn_motorsport_off.jpg'" border="0"></a>
		<img src="design/buttons/sub_pipe.jpg">
		<a href="gallery_contents.php?section_id=3"><img src="design/buttons/btn_goodwood_off.jpg" onMouseOver="this.src='design/buttons/btn_goodwood_on.jpg'"  onMouseOut="this.src='design/buttons/btn_goodwood_off.jpg'" border="0"></a>
		<img src="design/buttons/sub_pipe.jpg">
		<a href="gallery_contents.php?section_id=4"><img src="design/buttons/btn_marine_off.jpg" onMouseOver="this.src='design/buttons/btn_marine_on.jpg'" onMouseOut="this.src='design/buttons/btn_marine_off.jpg'" border="0"></a>
		<img src="design/buttons/sub_pipe.jpg">
		<a href="gallery_thumb.php?section_id=<?php echo $this->latest_event('section_id') ?>&category_id=<?php echo $this->latest_event('category_id') ?>"><img src="design/buttons/btn_latestevent_off.jpg" onMouseOver="this.src='design/buttons/btn_latestevent_on.jpg'" onMouseOut="this.src='design/buttons/btn_latestevent_off.jpg'" border="0"></a>
		</div>
	</div>
<?php }
//=======================================================================================================
function html_bottom() { ?>
	</body>
	</head>
<?php }
//=======================================================================================================
function latest_event($id) {
	$query = "SELECT * FROM categories WHERE 1 ORDER BY date DESC LIMIT 0,1";
	$result = mysql_query($query);	
	$row = mysql_fetch_assoc($result);
	return $row[$id];
}
//=======================================================================================================
} ?>
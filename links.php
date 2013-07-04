<?php session_start();
require_once('Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);
include('classes/class_u_output.php');
$output = new output;

$links_array[] =array (title_image=>'title_historicformulaone.jpg', text=>'Official website for the FIA Historic Formula One Championship', url=>'www.historicformulaone.com');
$links_array[] =array (title_image=>'title_lemansclassic.jpg', text=>'Historic race which takes place every two years for cars that competed between 1923 and 1979', url=>'www.lemansclassic.com');
$links_array[] =array (title_image=>'title_lemans-series.jpg', text=>'Official website for European endurance sports car racing', url=>'www.lemans-series.com');
$links_array[] =array (title_image=>'title_lemans.jpg', text=>'Official website for the ACO and the 24 hours of Le Mans', url=>'www.lemans.org');
$links_array[] =array (title_image=>'title_classicenduranceracing.jpg', text=>'Historic racing for 1966 – 1979 Le Mans style cars run in conjunction with the Le Mans Series', url=>'www.classicenduranceracing.com');
$links_array[] =array (title_image=>'title_themastersseries.jpg', text=>'Official website for the series which covers historic saloon, sports and Formula 1 cars', url=>'www.themastersseries.com');
$links_array[] =array (title_image=>'title_groupcracing.jpg', text=>'Official website for classic sports cars of the Group C era', url=>'www.groupcracing.com');
$links_array[] =array (title_image=>'title_goodwood.jpg', text=>'Official website for the Goodwood Revival and Goodwood Festival of Speed', url=>'www.goodwood.co.uk');
$links_array[] =array (title_image=>'title_okewoodimagery.jpg', text=>'Website construction', url=>'www.okewoodimagery.com');

$head = '';
$body = '';
$output->html_top($head, $body);
$output->menu();
//=================================================================================================
?>
<div id="image" style="margin-left:auto; margin-right:auto; width:658px; padding-bottom:20px;">
	<img src="design/photos/links.jpg" width="658" height="355" id="slide1">
</div>
<div id="text" style="margin-left:auto; margin-right:auto; width:658px;">
	<p class="para_header" style="padding:20px 0px 20px 0px;"><img src="design/titles/title_links.jpg"></p>
	<?php foreach($links_array as $x) { ?>
		<p class="section"><a href="http://<?php echo $x['url'] ?>" target="_blank"><img src="design/titles/<?php echo $x['title_image'] ?>" border="0"></a><br>
		<?php echo $x['text'] ?><br>
		<a href="http://<?php echo $x['url'] ?>" target="_blank" style="color:#999999;"><?php echo $x['url'] ?></a></p>
	<?php } ?>
</div>
<?php
//================================================================================================= 
$output->html_bottom();
?>

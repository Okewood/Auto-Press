<?php require_once('Connections/connAutoPress.php');
mysql_select_db($database_connAutoPress, $connAutoPress);

$i=1;
$query = "select * from images where 1";
$result = mysql_query($query, $connAutoPress) or die;
while($row = mysql_fetch_assoc($result)) {
	$image_id = $row['image_id'];
	$file_name = $row['file_name'];
	if(!file_exists('images/'.$file_name)) {
		$new_file_name = str_replace("jpg","JPG",$file_name);
		if(file_exists('images/'.$new_file_name)) {
			$query = "update images set file_name='".$new_file_name."' where file_name='".$file_name."'";
			echo $i.' '.$query.'<br>';
			$result2 = mysql_query($query, $connAutoPress) or die;
		} else {
			echo $i.' '.$file_name.': not found <br>';
		}
		$i++;
	}
}
/* echo '<pre>';
print_r($data);
echo '</pre>'; */
?>
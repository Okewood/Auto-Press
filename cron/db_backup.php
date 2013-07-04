<?php /*
database back-up to run once a day and overwrites similar file from yesterday or send email if address added, below
designed to run from cron/ directory in root
requires db_backup/ directory in root
php -q /home/okewood/public_html/cron/db_backup.php
*/
require_once('../Connections/connAutoPress.php'); 
mysql_select_db($database_connAutoPress, $connAutoPress);

//ENTER EMAIL ADDRESS HERE best that the email address is not from the same domain (leave blank if not required and sql file will be left on server)
$email_to = ''; 

$directory = '../db_backup/';

function create_zip($files = array(),$destination = '',$overwrite = true) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	} else {
		return false;
	}
}
//get all of the tables 
$result = mysql_query('SHOW TABLES', $connAutoPress); 
while($row = mysql_fetch_row($result)) { $tables[] = $row[0]; }
//cycle through 
foreach($tables as $table) { 
	$filename = $table.'.sql';
	$file = $directory.$filename;
	@unlink($file);
	$handle = fopen($file,'a+');

    $result = mysql_query('SELECT * FROM '.$table, $connAutoPress); 
    $num_fields = mysql_num_fields($result); 
     
    $return = 'DROP TABLE `'.$table."`;\n"; 
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table, $connAutoPress)); 
    $return.= "\n\n".$row2[1].";\n\n"; 
     
    for ($i = 0; $i < $num_fields; $i++) { 
      while($row = mysql_fetch_row($result)) { 
        $return.= 'INSERT INTO '.$table.' VALUES('; 
        for($j=0; $j<$num_fields; $j++) { 
          $row[$j] = addslashes($row[$j]); 
          $row[$j] = ereg_replace("\n","\\n",$row[$j]); 
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; } 
          if ($j<($num_fields-1)) { $return.= ','; } 
        } 
        $return.= ");\n"; 
      } 
    } 
    $return.="\n\n\n"; 
	fwrite($handle,$return); 
	$files_to_zip[] = $directory.$filename;
	fclose($handle); 
} 
//print_r($files_to_zip);
$zipfilename = 'db-backup_'.date('Y-m-d').'.zip';
$zipfile = $directory.$zipfilename;
create_zip($files_to_zip,$zipfile);

//delete files
foreach($files_to_zip as $file) {
	unlink($file);
}

//send as email attachment
if(!empty($email_to)) {
	include('../classes/class_email.php');
	$em = new email;
	$to = $email_to;
	$subject = 'Database back-up '.$zipfilename.' ('.date('d-m-Y').')';
	$message = 'Database back-up attached.<br>
				<br>
				It is fine to delete even the most recent message as long as your email system keeps them, perhaps in a Recycle Bin, for a period of time.<br>
				<br>
				** Message ends **';
	$em->send_email($to, $subject, $message, '', '', '', $zipfile, 1);
	unlink($zipfile);
}
?>
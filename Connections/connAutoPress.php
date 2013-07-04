<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connAutoPress = "192.168.2.6";
$database_connAutoPress = "kdivcms_autopress";
$username_connAutoPress = "kdivcms_adm1ner";
$password_connAutoPress = "aDm1n*Pw";
$connAutoPress = mysql_pconnect($hostname_connAutoPress, $username_connAutoPress, $password_connAutoPress) or trigger_error(mysql_error(),E_USER_ERROR); 
/* error_reporting(0);
if(!$connDB = mysql_pconnect($hostname_connDB, $username_connDB, $password_connDB)) {
	echo 'Sorry, we are unable to connect to the database server at this time. Please try again later.'; 
	exit;
} */
foreach($_FILES as $fieldname=>$array) {
	foreach($array as $key=>$val) {
		if(!is_array($val)) { 
			if(get_magic_quotes_gpc()) $val = stripslashes($val);
			$replace = array('<HEAD>','<BODY>','<IFRAME>','<META ','<A ','.HTM','.HTML','.PHP','.NET','.ASP','.ZIP','.SQL','<head>','<body>','<iframe>','<meta ','<a ','.htm','.html','.php','.net','.asp','.zip','.sql');
			$val = str_replace($replace, "", $val); 
			$_FILES[$fieldname][$key] = mysql_real_escape_string($val); 
		}
	}
}
foreach($_REQUEST as $key=>$val) {
	if(!is_array($val)) { 
		if(get_magic_quotes_gpc()) $val = stripslashes($val);
		$replace = array('<HEAD>','<BODY>','<IFRAME>','<META ','<A ','<head>','<body>','<iframe>','<meta ','<a ');
		$val = str_replace($replace, "", $val);   
		$search = array("\\","\0","\x1a","'",'"');
		$replace = array("\\\\","\\0","\Z","\'",'\"');
		$_REQUEST[$key] = str_replace($search,$replace,$val);
	}
}
?>
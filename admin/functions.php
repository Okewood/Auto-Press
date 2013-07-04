<?php
function get_co_name() {
	return 'auto-press';
}
function get_co_host() {
	return 'www.auto-press.com';
}
function get_co_email() {
	return 'system@auto-press.com';
}
function login($email, $password) {
  $password = encrypt($password);
  // check if username is unique
  $query = "select * from users where email='$email'";
  $result = mysql_query($query);
  if (!$result)
     return "Problem: no result from database";
  
  if (mysql_num_rows($result)>0) {
	 $result2 = mysql_query("select * from users
                            where email='$email' AND password='$password'");
	 if (mysql_num_rows($result2)>0) {
		 $_SESSION['user_id'] = mysql_result($result2, 0, 'user_id');
		 $_SESSION['user_name'] = mysql_result($result2, 0, 'email');
		 return "Thank you ".$_SESSION['user_name'].", you are now logged in";
	 }
	 else
 	     return "Problem: password incorrect";
  }
  else {
     return "Problem: email not found";
  }
}
function notify_password($email)
// notify the user of their password
{  
	$result = mysql_query("select email, password from users where email='$email'");
    if (!$result) {
     return 'Problem: no result from database.';
    }
    else if (mysql_num_rows($result)==0) {
      return 'Problem: email not found.';
    } else {
	  $row = mysql_fetch_assoc($result);
	  //$password = mysql_result($result, 0, 'password');
      //$name = $row['title'].' '.$row['last_name'];
	  $password = decrypt($row['password']);
	  $from = 'From: '.get_co_email()."\r\n";
      $mesg = "The information you requested is: '$password'. \r\n"
	  		."\r\n"
			."Yours,\r\n"
	  		."\r\n"
			.get_co_name()."\r\n"
			.get_co_host();
      
      if (mail($email, get_co_name()." information", $mesg, $from))
        return 'Email sent.';
      else
        return 'Problem: server error, email not sent. Please try again';     
    }
}
function valid_email($address)
{
  // check an email address is possibly valid
  if (ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $address))
    return true;
  else 
    return false;
}
function update_register($user_id, $email, $password)
{
  // check if email is unique 
  $result = mysql_query("select * from users 
  					where email='$email'
					and user_id<>'$user_id'"); 
  if (!$result)
     return 'Problem: could not execute query.';
  if (empty($email) || empty($password)) 
     return 'Problem: required field(s) missing.';
  if(!valid_email($email))
	 return 'Problem: the email address is invalid, please re-enter.';
  if (mysql_num_rows($result)>0) 
     return 'Problem: that email address is already in our system.';

  // if ok, put in db
  $result = mysql_query("update users 
					  set email='$email', password='$password'
					  where user_id=$user_id");
  if (!$result)
    return 'Problem: could not update the database - please try again later.';

  $_SESSION['user_email'] = $email;
  return 'Details updated.';
}

function upload_jpeg($upload_dir, $keep_dir, $keep_filename='', $append=0) { 
	 //parameters:-
	 // 1. directory to upload to, including path from calling program
	 // 2. directory to keep file, including path from calling program
	 // 3. new filename; default blank which will retain uploaded file name
	 // 4. 1 or 0 to append original filename at end of $keep_filename (default no)
		$feedback=0;
		global $newfilename;
		// $userfile is where file went on webserver
		$userfile = $_FILES['userfile']['tmp_name'];
		// $userfile_name is original file name
		$userfile_name = $_FILES['userfile']['name'];
		// $userfile_size is size in bytes
		$userfile_size = $_FILES['userfile']['size'];
		// $userfile_type is mime type e.g. image/gif
		$userfile_type = $_FILES['userfile']['type'];
		// $userfile_error is any error encountered
		$userfile_error = $_FILES['userfile']['error'];

		if (!$feedback && $userfile_error > 0) {
		    $feedback =  'Problem: ';
	    	switch ($userfile_error) {
		      case 1:  $feedback = $feedback.'File exceeded upload_max_filesize';  break;
		      case 2:  $feedback = $feedback.'File exceeded max_file_size';  break;
	    	  case 3:  $feedback = $feedback.'File only partially uploaded';  break;
		      case 4:  $feedback = $feedback.'No file uploaded: '.$_FILES['userfile1']['name'];  break;
		    }
		}
		// one more check: does the file have the right MIME type?
		if (!$feedback && $userfile_type != 'image/pjpeg' && $userfile_type != 'image/jpeg')
			$feedback = 'Problem: file is not a JPEG image file: '.$userfile_type;

		// is_uploaded_file and move_uploaded_file added at version 4.0.3
		$upfile = $upload_dir.$userfile_name;
		$newfilename = (!empty($keep_filename) ? $keep_filename : $userfile_name);
		$keepfile = $keep_dir.$newfilename;
		if (!$feedback) {
		  if(is_uploaded_file($userfile)) {
		     if (!move_uploaded_file($userfile, $upfile)) {
		        $feedback =  'Problem: Could not move '.$userfile.' to '.$upfile;
		     } else {
				//check size, make email version max 300px and put into email directory
				// Send JPeg MIME type as part of the HTTP Header
				Header("Content-type: image/jpeg");

				//get dimensions of uploaded image
				$size = getImageSize($upfile);
				$i_width = $size[0];
				$i_height = $size[1];
				$ratio = $i_width / $i_height;
				$maxheight = 350;
				$maxwidth = 540;
				if($ratio==1) { $w = $maxheight; $h = $maxheight; 
				} else { $h = $maxheight; $w = $maxheight/$i_height*$ratio; }
				$large_w = $w;
				$large_h = $h;
				//load the uploaded image from temp
				$UpImage = ImageCreateFromJPEG($upfile);
				if($i_width>$maxwidth || $i_height>$maxheight) {
					//create image handler for new large image
					$NewImage = ImageCreateTrueColor($large_w,$large_h);
					//resize and write to images_clt_lg directory
					ImageCopyResampled($NewImage,$UpImage,0,0,0,0,$large_w,$large_h,$i_width,$i_height);
					ImageJPEG($NewImage,$keepfile,85);		
					// Free memory
					ImageDestroy($NewImage);
				} else {
					//copy from temp to email
					if(!copy($upfile,$keepfile))
						$feedback = 'Failed to copy image from '.$upfile.' to '.$keepfile;
				}
				//delete file temp directory
				$deleted = unlink(trim($upfile));
			    //end create email image code
			 }
		  } else {
			  $feedback = 'Problem: Possible file upload attack. Filename: '.$new_ref;
		  }
		}
return($feedback);
}
function upload_header($upload_dir, $keep_dir, $keep_filename='', $append=0) { 
	 //parameters:-
	 // 1. directory to upload to, including path from calling program
	 // 2. directory to keep file, including path from calling program
	 // 3. new filename; default blank which will retain uploaded file name
	 // 4. 1 or 0 to append original filename at end of $keep_filename (default no)
		$feedback=0;
		global $newfilename;
		// $userfile is where file went on webserver
		$userfile = $_FILES['userfile2']['tmp_name'];
		// $userfile_name is original file name
		$userfile_name = $_FILES['userfile2']['name'];
		// $userfile_size is size in bytes
		$userfile_size = $_FILES['userfile2']['size'];
		// $userfile_type is mime type e.g. image/gif
		$userfile_type = $_FILES['userfile2']['type'];
		// $userfile_error is any error encountered
		$userfile_error = $_FILES['userfile2']['error'];

		if (!$feedback && $userfile_error > 0) {
		    $feedback =  'Problem: ';
	    	switch ($userfile_error) {
		      case 1:  $feedback = $feedback.'File exceeded upload_max_filesize';  break;
		      case 2:  $feedback = $feedback.'File exceeded max_file_size';  break;
	    	  case 3:  $feedback = $feedback.'File only partially uploaded';  break;
		      case 4:  $feedback = $feedback.'No file uploaded: '.$_FILES['userfile2']['name'];  break;
		    }
		}
		// one more check: does the file have the right MIME type?
		if (!$feedback && $userfile_type != 'image/pjpeg' && $userfile_type != 'image/jpeg')
			$feedback = 'Problem: event image file is not a JPEG image file: '.$userfile_type;

		// is_uploaded_file and move_uploaded_file added at version 4.0.3
		$upfile = $upload_dir.$userfile_name;
		$newfilename = (!empty($keep_filename) ? $keep_filename : $userfile_name);
		$keepfile = $keep_dir.$newfilename;
		if (!$feedback) {
		  if(is_uploaded_file($userfile)) {
		     if (!move_uploaded_file($userfile, $upfile)) {
		        $feedback =  'Problem: Could not move '.$userfile.' to '.$upfile;
		     } else {
				//check size, make email version max 300px and put into email directory
				// Send JPeg MIME type as part of the HTTP Header
				Header("Content-type: image/jpeg");

				//get dimensions of uploaded image
				$size = getImageSize($upfile);
				$i_width = $size[0];
				$i_height = $size[1];
				$ratio = $i_width / $i_height;
				$maxheight = 356;
				$maxwidth = 658;
				if($ratio==1) { $w = $maxheight; $h = $maxheight; 
				} else { $h = $maxheight; $w = $maxheight/$i_height*$ratio; }
				$large_w = $w;
				$large_h = $h;
				//load the uploaded image from temp
				$UpImage = ImageCreateFromJPEG($upfile);
				if($i_width>$maxwidth || $i_height>$maxheight) {
					//create image handler for new large image
					$NewImage = ImageCreateTrueColor($large_w,$large_h);
					//resize and write to images_clt_lg directory
					ImageCopyResampled($NewImage,$UpImage,0,0,0,0,$large_w,$large_h,$i_width,$i_height);
					ImageJPEG($NewImage,$keepfile,85);		
					// Free memory
					ImageDestroy($NewImage);
				} else {
					//delete existing file if exists
					if(file_exists($keepfile) && !is_dir($keepfile)) {
						unlink($keepfile);
					}
					//copy from temp
					if(!copy($upfile,$keepfile))
						$feedback = 'Failed to copy image from '.$upfile.' to '.$keepfile;
				}
				//delete file temp directory
				$deleted = unlink(trim($upfile));
			    //end create email image code
			 }
		  } else {
			  $feedback = 'Problem: Possible file upload attack. Filename: '.$new_ref;
		  }
		}
return($feedback);
}

function safe_b64encode($string) {
	$data = base64_encode($string);
	$data = str_replace(array('+','/','='),array('-','_',''),$data);
	return $data;
}

function safe_b64decode($string) {
	$data = str_replace(array('-','_'),array('+','/'),$string);
	$mod4 = strlen($data) % 4;
	if ($mod4) {
		$data .= substr('====', $mod4);
	}
	return base64_decode($data);
}

function encrypt($value){ 
	if(!$value){return false;}
	$text = $value;
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, "CMSsalt", $text, MCRYPT_MODE_ECB, $iv);
	return trim(safe_b64encode($crypttext)); 
}

function decrypt($value){
	if(!$value){return false;}
	$crypttext = safe_b64decode($value); 
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, "CMSsalt", $crypttext, MCRYPT_MODE_ECB, $iv);
	return trim($decrypttext);
}
?>
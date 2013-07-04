<?php 
# set error reporting for this server
error_reporting(E_ALL ^ E_NOTICE);
include('classes/class_email.php');
$email = new email;

if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])) {
	$to = $_REQUEST['email'];
	$datetime = $_REQUEST['datetime'];
	$subject = 'Test';
	$message = 'Test message using:-<br>'
			.'IP: '.$email->co_host_ip.'<br>'
			.'U/N: '.$email->co_host_un.'<br>'
			.'P/W: '.$email->co_host_pw.'<br>';
	
	if(mail($to, $subject.' '.date('d-m-y H:i:s').' (php mail() function)', $message, "From: OI <email@okewoodimagery.com>\n")) {
		echo 'PHP plain email sent.';
	} else {
		echo 'PHP plain email not sent.';
	}
	echo '<br>';
		
	$smtp_feedback = $email->send_email($to, $subject.' '.$datetime.' (SMTP)', $message);
	echo 'SMTP feedback for email sent to '.$to.': '.$smtp_feedback;
	echo '<br>';
} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Test email</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php $datetime = date('d-m-y H:i:s'); ?>
<form action="test_email.php" method="post" name="form1">
  <p>Test emails from this server (<?php echo $_SERVER['SERVER_ADDR'] ?>) using the PHP mail() function and an SMTP email class (PHPMailer).</p>
  <p>Enter email address to receive test message...    </p>
  <input name="email" type="text" value="<?php echo $to ?>">  
  <input name="datetime" type="hidden" value="<?php echo $datetime ?>">
  <br>
  <br>
  <p>Subject: 'Test <?php echo $datetime ?> (function details)</p>
  <p>Message: <?php echo 'Test message using:-<br>'
			.'IP: '.$email->co_host_ip.'<br>'
			.'U/N: '.$email->co_host_un.'<br>'
			.'P/W: '.$email->co_host_pw.'<br>'; ?></p>
  <p><input name="Send" type="submit" value="Send"></p>
  <p>&nbsp;</p>
</form>
<?php 
echo '<pre>SERVER vars:<br>';
print_r($_SERVER);
echo '</pre>'; ?>
</body>
</html>

<?php class email {

var $co_name;
var $co_site_url;
var $co_host_ip;
var $co_host_un;
var $co_host_pw;

function email() {
	require("class.phpmailer.php");
	$this->co_name 		 = 'Auto-Press';
	$this->co_from_email = 'info@auto-press.com';
	$this->co_host_ip 	 = '78.110.174.10';
	$this->co_host_un 	 = 'kdivcms';
	$this->co_host_pw 	 = 'thufrecr';
}
function send_email($to,$subject,$message,$from='',$cc='',$att1='',$att2='',$att3='',$att4='',$att5='',$html=0) {
	$mail = new PHPMailer();
	$mail->IsSMTP();						// set mailer to use SMTP
	$mail->SMTPAuth = true;					// turn on SMTP authentication
	$mail->Host 	= $this->co_host_ip;	// specify main and backup server
	$mail->Username = $this->co_host_un;	// SMTP username
	$mail->Password = $this->co_host_pw;	// SMTP password
	$mail->WordWrap = 80;					// set word wrap to 80 characters
	$mail->From 	= (empty($from) ? $this->co_from_email : $from);
	$mail->FromName = $this->co_name;
	$mail->AddAddress($to);
	if(!empty($cc)) $mail->AddCC($cc);					// add CC
	if(!empty($att1)) $mail->AddAttachment($att1);		// add attachment
	if(!empty($att2)) $mail->AddAttachment($att2);		// add attachment
	if(!empty($att3)) $mail->AddAttachment($att3);		// add attachment
	if(!empty($att4)) $mail->AddAttachment($att4);		// add attachment
	if(!empty($att5)) $mail->AddAttachment($att5);		// add attachment
	$mail->Subject = $subject;
	if($html) {
		$mail->IsHTML(true);				// set email format to HTML
		$mail->Body = $message;
	} else {
		$mail->Body = stripslashes($message);
	}
	if(!$mail->Send()) {
		return FALSE;
	} else {
		return TRUE;
	}
	$mail->ClearAddresses ();
	$mail->CCs ();
	$mail->ClearAttachments ();
}
} ?>
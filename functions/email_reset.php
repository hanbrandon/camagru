<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
session_start();             
function email_reset($email, $username, $hash, $DB_PORT)
{
	$to      = $email; 
	$subject = 'Reset Password'; 
	$message = '
	
	Your password has been reset, you can login with the following credentials by pressing the url below.
	
	------------------------
    Username: '.$username.'
    Password: '.$hash.'
	------------------------
	
	Please click this link to login:
	http://localhost:'.$DB_PORT.'/?id=login.php
	
	'; 
    
	$headers = 'From:noreply@camagru.com' . "\r\n"; 
    mail($to, $subject, $message, $headers);
}
?>
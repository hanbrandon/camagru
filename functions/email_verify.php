<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

function email_verify($email, $username, $hash, $DB_PORT)
{
	$to      = $email; // Send email to our user
	$subject = 'Signup | Verification'; // Give the email a subject 
	$message = '
	
	Thanks for signing up!
	Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
	
	------------------------
	Username: '.$username.'
	------------------------
	
	Please click this link to activate your account:
	http://localhost:'.$DB_PORT.'/functions/verify.php?email='.$email.'&hash='.$hash.'
	
	'; // Our message above including the link
						
	$headers = 'From:noreply@testcamagru.com' . "\r\n"; // Set from headers
	mail($to, $subject, $message, $headers); // Send our email
}
?>
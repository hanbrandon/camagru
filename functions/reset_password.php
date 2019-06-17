<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

require_once '../config/setup.php';
require_once '../functions/email_reset.php';

if (!$_POST["submit"] === "Send Reset Password Link" || !$_POST["email"])
{	
	$_SESSION["error"] = "Enter Email Address";
	header("Location: ../?id=reset_password.php");
	exit();
}
try 
{
    $email = $_POST["email"];
    $hash = substr(md5(rand(0, 1000)), 0, 5);
    $passwd = hash("whirlpool", $hash);
    $check_email = $conn->prepare("SELECT * FROM users WHERE email=?");
    $check_email->execute(array($email));  
    if ($usernameRow=$check_email->fetch())
    {
        $username = $usernameRow['username'];
        $stmt = $conn->prepare("UPDATE users SET passwd='$passwd' WHERE username=?");
        $stmt->execute(array($username));
        email_reset($email, $username, $hash, $DB_PORT);
        $_SESSION["error"] = "Password has been reset.<br> Check your email";
        header("Location: ../?id=reset_password.php");
        exit();
    }

    
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>


<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
require_once '../config/setup.php';
require_once '../functions/email_verify.php';
session_start();

if (!$_POST["submit"] === "OK") 
{	
	$_SESSION["error"] = "Submit Error";
	header("Location: ../?id=register.php");
	exit();
}
if (!$_POST["username"] || !$_POST["passwd"]) 
{	
	$_SESSION["error"] = "Enter Username/Password";
	header("Location: ../?id=register.php");
	exit();
}
if ($_POST["passwd"] !== $_POST["passwd_conf"]) 
{	
	$_SESSION["error"] = "Passwords are not match";
	header("Location: ../?id=register.php");
	exit();
}
if (!$_POST["email"])
{	
	$_SESSION["error"] = "Enter Email";
	header("Location: ../?id=register.php");
	exit();
}
if (strlen($_POST["username"]) < 6 && strlen($_POST["username"]) > 30)
{
	$_SESSION["error"] = "Username Must be between 6 and 30 characters long";
	header("Location: ../?id=register.php");
	exit();
}
if (strlen($_POST["passwd"]) < 8)
{
	$_SESSION["error"] = " Password Must be at least 8 character long";
	header("Location: ../?id=register.php");
	exit();
}

if (!preg_match("#[0-9]+#", $_POST["passwd"])) {
	$_SESSION["error"] = "Password must include at least one number!";
	header("Location: ../?id=register.php");
	exit();
}
if (!preg_match("#[a-zA-Z]+#", $_POST["passwd"])) {
	$_SESSION["error"] = "Password must include at least one letter!";
	header("Location: ../?id=register.php");
	exit();
}
if (!preg_match("#[^\w]+#", $_POST["passwd"])) {
	$_SESSION["error"] = "Password must include at least one special Character!";
	header("Location: ../?id=register.php");
	exit();
}


try 
{
	$username = $_POST["username"];
	$passwd = hash("whirlpool", $_POST["passwd"]);
	$email = $_POST["email"];
	$hash = md5(rand(0,1000));

	$check_username = $conn->prepare("SELECT * FROM users WHERE username=?");
	$check_username->execute(array($username));

	$check_email = $conn->prepare("SELECT * FROM users WHERE email=?");
	$check_email->execute(array($email));

	if ($check_username->fetch())
	{
		$_SESSION["error"] = "Already Exists Username";
		header("Location: ../?id=register.php");
	}
	else if ($check_email->fetch())
	{
		$_SESSION["error"] = "Already Exists Email";
		header("Location: ../?id=register.php");
	}
	else
	{
		$stmt = $conn->prepare("INSERT INTO users (username, passwd, email, `hash`, verification) VALUES(?, ?, ?, ?, ?)");
		$val = $stmt->execute(array($username, $passwd, $email, $hash, 1));
		if ($val)
		{	
			email_verify($email, $username, $hash, $DB_PORT);
			$_SESSION["verify"] = $username;
			header("Location: ../?id=confirm.php");	
		}
	}	
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

?>


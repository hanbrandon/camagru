<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

require_once '../config/setup.php';
session_start();
if (!$_POST["submit"] === "LOGIN" || !$_POST["username"] || !$_POST["passwd"])
{	
	echo "ERROR\n";
	$_SESSION["error"] = "Please enter username/password";
	header("Location: ../?id=login.php");
	exit();
}
try 
{
	$username = $_POST["username"];
	$passwd = hash("whirlpool", $_POST["passwd"]);

	$check_username_pw = $conn->prepare("SELECT * FROM users WHERE username=? AND passwd=?");
	$check_username_pw->execute(array($username, $passwd));

	if ($usernameRow=$check_username_pw->fetch())
	{
		if ($usernameRow['verification'] == 1)
		{
			$_SESSION["logged_in"] = "$username";
			header("Location: ../"); 
			exit();
		}
		else
		{
			$_SESSION["verify"] = $username;
			header("Location: ../?id=confirm.php");
			exit();
		}
    }
	else 
	{
		$_SESSION["error"] = "Check your Username/Password";
		header("Location: ../?id=login.php");
		exit();
	}
}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>


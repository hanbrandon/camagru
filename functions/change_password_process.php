<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

require_once '../config/setup.php';
session_start();
if (!$_POST["submit"] === "OK" || !$_POST["passwd"] || !$_POST["new_passwd"] || !$_POST["confirm_new_passwd"] || ($_POST["new_passwd"] != $_POST["confirm_new_passwd"])) 
{	
	$_SESSION["error"] = "Submit error";
	header("Location: ../?id=change_password.php");
	exit();
}
if (!$_POST["passwd"] || !$_POST["new_passwd"] || !$_POST["confirm_new_passwd"])
{	
	$_SESSION["error"] = "Enter password";
	header("Location: ../?id=change_password.php");
	exit();
}
if ($_POST["new_passwd"] != $_POST["confirm_new_passwd"])
{	
	$_SESSION["error"] = "Passwords are not match";
	header("Location: ../?id=change_password.php");
	exit();
}
if (strlen($_POST["new_passwd"]) < 8)
{
	$_SESSION["error"] = " Password Must be at least 8 character long";
	header("Location: ../?id=change_password.php");
	exit();
}

if (!preg_match("#[0-9]+#", $_POST["new_passwd"])) {
	$_SESSION["error"] = "Password must include at least one number!";
	header("Location: ../?id=change_password.php");
	exit();
}
if (!preg_match("#[a-zA-Z]+#", $_POST["new_passwd"])) {
	$_SESSION["error"] = "Password must include at least one letter!";
	header("Location: ../?id=change_password.php");
	exit();
}
if (!preg_match("#[^\w]+#", $_POST["new_passwd"])) {
	$_SESSION["error"] = "Password must include at least one special Character!";
	header("Location: ../?id=change_password.php");
	exit();
}
try 
{
	$username = $_SESSION['logged_in'];
    $old_passwd = hash("whirlpool", $_POST["passwd"]);
	$new_passwd = hash("whirlpool", $_POST["new_passwd"]);

    $check_username_old_pw = $conn->prepare("SELECT * FROM users WHERE username=? AND passwd=?");
	$check_username_old_pw->execute(array($username, $old_passwd));

	if ($check_username_old_pw->fetch())
	{
        $stmt = $conn->prepare("UPDATE users SET passwd='$new_passwd' WHERE username=? AND passwd=?");
        $stmt->execute(array($username, $old_passwd));
        $_SESSION["error"] = "Password Updated";
        header("Location: ../?id=change_password.php");
    }
    else
    {
        $_SESSION["error"] = "Wrong Password";
        header("Location: ../?id=change_password.php");
        exit();
    }
	
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>


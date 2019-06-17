<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

require_once '../config/setup.php';
session_start();
if (!$_POST["submit"] === "SAVE")
{	
	header("Location: ../?id=my_account.php");
	exit();
}
try 
{
    $username = $_SESSION['logged_in'];
    if (isset($_POST["noti"] )) {
        if ($_POST["noti"] == 'on')
        {
            $noti = "1";
        }
        else
        {
            $noti = "0";
        }
    }
    else
    {
        $noti = "0";
    }
	$check_username = $conn->prepare("SELECT * FROM users WHERE username=?");
	$check_username->execute(array($username));

	if ($check_username->fetch())
	{
        $stmt = $conn->prepare("UPDATE users SET noti='$noti' WHERE username=?");
        $stmt->execute(array($username));
        $_SESSION["error"] = "Notification Setting Updated";
        header("Location: ../?id=notification.php");
    }
	
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>


<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

require_once './config/setup.php';
try 
{
	$username = $_SESSION["logged_in"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute(array($username));
    $usernameRow=$stmt->fetch();
    if ($usernameRow['noti'] == 1)
    {
        $email_noti = "checked";
    }
    else
    {
        $email_noti = "";
    }
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>


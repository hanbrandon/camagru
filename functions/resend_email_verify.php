<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
require_once '../config/setup.php';
require_once '../functions/email_verify.php';
session_start();
try 
{
	$username = $_SESSION["verify"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute(array($username));
    if ($usernameRow=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        $email = $usernameRow['email'];
        $hash = $usernameRow['hash'];
        email_verify($email, $username, $hash, $DB_PORT);
        header("Location: ../?id=confirm.php");
    }
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>
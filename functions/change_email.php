<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

require_once '../config/setup.php';
session_start();
if (!$_POST["submit"] === "OK" || !$_POST["username"] || !$_POST["email"])
{	
	$_SESSION["error"] = "Enter Username or Email";
	header("Location: ../?id=my_account.php");
	exit();
}
try 
{
    $username = $_SESSION['logged_in'];
    $new_username = $_POST["username"];
	$new_email = $_POST["new_email"];

    if ($username != $new_username)
    {
        $check_new_username = $conn->prepare("SELECT * FROM users WHERE username=?");
        $check_new_username->execute(array($new_username));
        
        //Check Username Exist or not
        if ($check_new_username->fetch())
	    {
            $_SESSION["error"] = "Already Exists Username";
            header("Location: ../?id=my_account.php");
            exit();
        }
        else
        {
            //Update Username
            $stmt = $conn->prepare("UPDATE users SET username='$new_username' WHERE username=?");
            $stmt->execute(array($username));
            $_SESSION["logged_in"] = $new_username;
            header("Location: ../?id=my_account.php");
            exit();
        }
    }
    if ($new_email != "")
    {
        $username = $_SESSION['logged_in'];
        $check_new_email = $conn->prepare("SELECT * FROM users WHERE email=?");
        $check_new_email->execute(array($new_email));
        
        if ($check_new_email->fetch())
        {
            $_SESSION["error"] = "Already Exists Email";
            header("Location: ../?id=my_account.php");
            exit();
        }
        else
        {
            $sql = "UPDATE users SET email='$new_email' WHERE username='$username'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $_SESSION["error"] = "Email Updated";
            header("Location: ../?id=my_account.php");
            exit();
        }
    }
    if ($username == $new_username)
    {
        $_SESSION["error"] = "Enter New Username Or Email Address";
        header("Location: ../?id=my_account.php");
        exit();
    }
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>


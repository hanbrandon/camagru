<?php
require_once '../config/setup.php';
session_start();             
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = basename($_GET['email']); // Set email variable
    $hash = basename($_GET['hash']); // Set hash variable
                 
    $search = $conn->prepare("SELECT username, email, hash, verification FROM users WHERE email=? AND hash=? AND verification='0'");
    $search->execute(array($email, $hash));
    $match  = $search->fetch();
                 
    if($match > 0){
        // We have a match, activate the account
        $stmt = $conn->prepare("UPDATE users SET verification='1' WHERE email=? AND hash=? AND verification='0'");
        $stmt->execute(array($email, $hash));
        //$_SESSION["error"] = "Email Verified";
        $_SESSION["logged_in"] = $match["username"];
        header("Location: ../");
    }
    else
    {
        // No match -> invalid url or account has already been activated.
       $_SESSION["error"] = "Invalid URL or Activated Account";
       header("Location: ../?id=login.php");
       exit();
    }
}
else
{
    // Invalid approach
    $_SESSION["error"] = "Invalid approach, please use the link that has been send to your email.";
    header("Location: ../?id=login.php");
    exit();
}
?>
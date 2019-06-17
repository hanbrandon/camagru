<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
require_once '../config/setup.php';
session_start();
// Handling data in JSON format on the server-side using PHP
header("Content-Type: application/json");
// build a PHP variable from JSON sent using POST method
$v = json_decode(stripslashes(file_get_contents("php://input")));

try 
{
    $username = $v->username;
    $img_path = $v->img_path;
    
    $check_username = $conn->prepare("SELECT * FROM likes WHERE img_path=? AND username=?");
    $check_username->execute(array($img_path, $username));

    if ($check_username->fetch())
    {
        $stmt = $conn->prepare("DELETE FROM likes WHERE img_path=? AND username=?");
        $stmt->execute(array($img_path, $username)); 
    }   
    else
    {
        $stmt = $conn->prepare("INSERT INTO likes (img_path, username) VALUES(?, ?)");
        $stmt->execute(array($img_path, $username));        
    }
    $check_likes = $conn->prepare("SELECT * FROM likes WHERE img_path=?");
    $check_likes->execute(array($img_path));
    $like = $check_likes->rowCount();
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
echo json_encode($like);
?>
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
    $img_id = $v->img_path;
    
    //Delete Post 
    $get_postInfo = $conn->prepare("SELECT * FROM posts WHERE id=?");
    $get_postInfo->execute(array($img_id));
    $postInfoRow = $get_postInfo->fetch();
    $img_path = $postInfoRow['img_path'];

    $delete_post = $conn->prepare("DELETE FROM posts WHERE id=?");
    $delete_post->execute(array($img_id));
    //Delete Images
    unlink($img_path);
    //Delete Likes
    $delete_likes = $conn->prepare("DELETE FROM likes WHERE img_path=?");
    $delete_likes->execute(array($img_id));
    //Delete Comments
    $delete_comments = $conn->prepare("DELETE FROM comments WHERE img_path=?");
    $delete_comments->execute(array($img_id));
    //header("Location: ../");

}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>
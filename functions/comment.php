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
    $comment = $v->comment;
        
    $addComment = $conn->prepare("INSERT INTO comments (img_path, username, comment) VALUES(?, ?, ?)");
    $addComment->execute(array($img_path, $username ,$comment));        
    
    $stmt = $conn->prepare("SELECT * FROM comments WHERE img_path=? ORDER BY id desc");
    $stmt->execute(array($img_path));
    $last_id = $stmt->rowCount();
    $j = 1;
    while ($next = $stmt->fetch())
    {
        $commentRow[$j]['username'] = $next['username'];
        $commentRow[$j]['comment'] = $next['comment'];
        $j++;
    }

    $get_author = $conn->prepare("SELECT * FROM posts WHERE id=?");
    $get_author->execute(array($img_path));
    $authorRow = $get_author->fetch();
    $author = $authorRow['username'];

    $get_authorInfo = $conn->prepare("SELECT * FROM users WHERE username=?");
    $get_authorInfo->execute(array($author));
    $authorInfoRow = $get_authorInfo->fetch();
    $email = $authorInfoRow['email'];
    $notification = $authorInfoRow['noti'];

    if ($notification) {
        email_notification($email, $author, $DB_PORT);
    } 
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
echo json_encode($commentRow);

function email_notification($email, $username, $DB_PORT)
{
	$to      = $email; 
	$subject = 'Someone wrote a comment!'; 
	$message = '
	
    Hello '.$username.',
    Someone wrote a comment on your post!
	
	'; 
						
	$headers = 'From:noreply@camagru_test.com' . "\r\n"; 
	mail($to, $subject, $message, $headers);
}
?>
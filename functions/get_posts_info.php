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
    $from = $v->from;
    
    $stmt = $conn->prepare("SELECT * FROM posts ORDER BY id desc LIMIT $from, 5");
    $stmt->execute();
    $last_id = $stmt->rowCount();
    $j = 1;
    while ($next = $stmt->fetch())
    {
        //get post info
        $postRow['img_path'][$j] = $next['img_path'];
        $postRow['username'][$j] = $next['username'];
        $postRow['id'][$j] = $next['id'];

        //get likes 
        $count_likes = $conn->prepare("SELECT * FROM likes WHERE img_path=?");
        $count_likes->execute(array($postRow['id'][$j]));
        $postRow['like'][$j] = $count_likes->rowCount();

        //get comments
        $get_comments = $conn->prepare("SELECT * FROM comments WHERE img_path=?");
        $get_comments->execute(array($postRow['id'][$j]));
        $last_comment_id[$j]= $get_comments->rowCount();
        $i = 1;
        while ($nextComment = $get_comments->fetch())
        {
            $commentRow[$j][$i]['username'] = $nextComment['username'];
            $commentRow[$j][$i]['comment'] = $nextComment['comment'];
            $i++;
        }
        $j++;
    }
    $i = 1;
    $content = '';
    while ($i <= $last_id)
    {
        $content = $content . '
        <div class="feed">
            <div class="feed-header">
                <span>'.$postRow['username'][$i].'</span>
                <div id="delete">';
        if (isset($_SESSION['logged_in']))
        {
            if ($_SESSION['logged_in'] == $postRow['username'][$i])
            {
                $content = $content . '<a onclick="deletepost('.$postRow['id'][$i].');"><i class="fas fa-bars"></i></a>';
            }
        }
        $content = $content . '</div>
            </div>
            <div class="feed-image">
                <img src="'.$postRow['img_path'][$i].'" />
            </div>
            <div class="feed-body" >
                <form id="likeform" method="post">';
        if (isset($_SESSION['logged_in']))
        { 
            $content = $content . '<input type="hidden" id="username" name="username" value="'.$_SESSION['logged_in'].'"><a  onclick="submitlike('.$postRow['id'][$i].');">';
        }
        $content = $content . '<i class="far fa-heart"></i></a><span id="p'.$postRow['id'][$i].'">'.$postRow['like'][$i].' like</span>
                </form>
                <div class="comments" id="comments'.$postRow['id'][$i].'">';
        $j = 1; 
        while ($j <= $last_comment_id[$i])
        {
            $content = $content . '<p><strong>'.$commentRow[$i][$j]['username'].'</strong> '.$commentRow[$i][$j]['comment'].'</p>';
            $j++;
        }	
                $content = $content . '</div>
            </div>';
        if (isset($_SESSION['logged_in']))
        { 
            $content = $content . '<div class="feed-footer">
            <form>
                <input type="text" class="ny" id="comment'.$postRow['id'][$i].'" placeholder="Add a comment..."/>
                <a onclick="submitcomment('.$postRow['id'][$i].');"><i class="far fa-comment"></i></a>
            </form>
        </div>';
        }
            
        $content = $content . '</div>';
        $i++;
    }
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
echo json_encode($content);
?>



<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

if(isset($_POST['Submit']))
{ 
    $filepath = "..images/" . $_FILES["file"]["name"];
    
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) 
    {
        echo "<img src=".$filepath." height=200 width=300 />";
        header("Location: ../?id=upload.php");
    } 
    else 
    {
        header("Location: ../?id=upload.php");
    }
} 
?>
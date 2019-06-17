<?php
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

require_once '../config/setup.php';
session_start();


if (!$_POST["submit"] === "UPLOAD" || !$_POST["image"] || !$_POST["sticker"])
{	
	$_SESSION["error"] = "No image or sticker";
	header("Location: ../?id=upload.php");
	exit();
}
try
{
	date_default_timezone_set('America/Los_Angeles');
	$date = date('Y-m-d H:i:s', time());

	$ini = $_POST['image'];
	$images = explode("&", $ini);
	$img = $images[0];
	$sticker = "../emoji/" . $images[1];

	$folderPath = "../upload/";
	$image_parts = explode(";base64,", $img);
	$image_type_aux = explode("image/", $image_parts[0]);
	$image_type = $image_type_aux[1];

	$image_base64 = base64_decode($image_parts[1]);
	$fileName = uniqid() . '.png';

	$file = $folderPath . $fileName;
	file_put_contents($file, $image_base64);

	//merge start 

	$dest = imagecreatefrompng($file); //dest = webcam
	$src = imagecreatefrompng($sticker . '.png'); //src sticker


	$imageinfo = getimagesize($file);
          
	$ix=$imageinfo[0];
	$iy=$imageinfo[1];

	$ix = $ix/2 - 125;
	$iy = $iy/2 - 125;

	echo $ix;
	echo $iy;
	imagecopy($dest, $src, $ix, $iy, 0, 0, 250, 250);
	header('Content-Type: image/png');
	imagepng($dest, $file);

	imagedestroy($dest);
	imagedestroy($src);

	$username = $_SESSION["logged_in"];
	$stmt = $conn->prepare("INSERT INTO posts (img_path, username, post_date) VALUES(?, ?, ?)");
	$stmt->execute(array($file, $username, $date));
	header("Location: ../");
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

?>
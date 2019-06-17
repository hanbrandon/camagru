<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) 
{
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
if (!(isset($_SESSION['logged_in'])))
{ 
	header("Location:.?id=login.php");
}
else
{
?>
<script>
	function displaySticker() {
		stickerfile = "../emoji/" + document.querySelector('input[name="sticker"]:checked').value + ".png";
		var sticker = document.getElementById("showSticker");
		sticker.src = stickerfile;
		
		if (document.getElementById('uploaded_image')) {
			var img = document.getElementById('uploaded_image');
			var imgWidth = img.naturalWidth;
			var imgHeight = img.naturalHeight;
			sticker.style.top = `calc(50% - ((250/${imgHeight})*100%)/2)`;
			sticker.style.left = `calc(50% - ((250/${imgWidth})*100%)/2)`;
			sticker.style.width = `calc((250/${imgWidth})*100%)`;
		}
	}
</script>
<form action="../functions/upload.php" method="POST">
    <div class="container upload">
        <div class="row">
            <div class="col-sm-1">               
            </div>
            <div class="col-sm-10 ">
				<div class="upload_menu">
					<a href="../?id=upload.php&type=cam">
						<i class="fas fa-camera"></i>
					</a>
				</div>
				<div class="upload_menu">
					<a href="../?id=upload.php&type=computer">
						<i class="fas fa-desktop"></i>
					</a>
				</div>
                <?php
				if (isset($_GET['type'])) 
				{
					if ($_GET['type'] === 'cam')
					{
						require_once("./pages/cam.php");
					}
					if ($_GET['type'] === 'computer')
					{
						require_once("./pages/computer.php");
					}						
				}
				else
				{
					header("Location: ../?id=upload.php&type=cam");
				}
				?>
				<input class="btn btn-success" name="submit" type="submit" value="UPLOAD" >
			</div>
			<div class="col-sm-1">
			</div>
        </div>
	</div>
</form>
<?php
}
?>

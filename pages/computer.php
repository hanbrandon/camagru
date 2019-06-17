<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<script src="/js/upload.js"></script>

<script>
    var loadFile = function (event) {
        var output = document.getElementById('uploaded_image');
        var file = event.target.files[0]
        var reader = new FileReader();

        reader.addEventListener('load', function () {
            output.src = reader.result;
        }, false);

        if (file) {
            reader. readAsDataURL(file);
        }
    };
</script>

<div class="contentarea">
    <div class="uploaded" id="camera">
        <img id="uploaded_image">
        <img id="showSticker">
        <button type="button" id="startbutton">TAKE PHOTO</button>
    </div>
    <canvas id="canvas"></canvas>
    <?php require_once("./pages/emoji.php");?>
    <div class="output" id="photo"></div>
    <div id="results"></div>
    <span>
        <?php 
            if (isset($_SESSION["error"]))
            {
                echo $_SESSION["error"]; 
                unset($_SESSION["error"]);
            }
        ?>
    </span>
</div>
<input onchange="loadFile(event)" type="file" accept="image/png">
<?php require_once("./pages/emoji.php");?>
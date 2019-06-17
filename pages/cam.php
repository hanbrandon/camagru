<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<script src="/js/capture.js"></script>
<div class="contentarea">
    <div class="camera" id="camera">
        <video id="video">Video stream not available.</video>
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
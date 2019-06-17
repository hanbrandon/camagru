<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<div class="bottom_emoji">
        <?php
        $directory = "./emoji/";
        $filecount = 0;
        $files = glob($directory . "*");
        if ($files)
        {
            $filecount = count($files);
            while ($filecount > 0) 
            {
                echo '<label><input type="radio" class="sticker" name="sticker" value="'.$filecount.'" onclick="displaySticker();"><img src="../emoji/'.$filecount.'.png"></label>';
                $filecount--;
            }
        }
        ?>
</div>
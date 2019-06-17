<?php
session_start();
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>Camagru</title>
        <link href="/css/style.css" rel="Stylesheet" type="text/css"/>
        <link
        crossorigin="anonymous" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" rel="stylesheet">
        <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" rel="stylesheet">
    </head>
    
    <body <?php
       if ($_SERVER['REQUEST_URI'] == '/')
       {
           echo 'onscroll="myFunction();" onload="galleryLoad();"';
       }
    ?>>
        <?php
			require_once('./menu/main_menu.php');
            if (isset($_GET['id']))
            {
                $page_id = basename($_GET['id']);
                require_once("./pages/$page_id");
            }
            else 
            {
                require_once("./pages/gallery.php");
            }
        ?>
    </body>
    <footer>
        <?php
			require_once('./pages/footer.php');
		?>
    </footer>
</html>

<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
if ( $_SESSION['logged_in'] == true )
{ //okay session is true
    require_once './functions/get_user_info.php';
}
else 
{
    header("Location:./?id=login.php");
}
?>
<div class="container myacct">
    <div class="row dashboard">
        <?php
            include('./menu/account_menu.php');
        ?>
        <div class="col-sm-8 col_short">
            <form action="../functions/change_notification_process.php" method="post">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox" name="noti">Email Notification
                    <input class="register_btn acct_btn" name="submit" type="submit" value="SAVE">
                    <div class="center">
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
                </div>
            </form>
        </div>
    </div>
</div>
    
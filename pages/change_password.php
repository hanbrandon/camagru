<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<div class="container myacct">
    <div class="row dashboard">
        <?php
            require_once ('./menu/account_menu.php');
            if ( $_SESSION['logged_in'] == true )
            { //okay session is true
                require_once './functions/get_user_info.php';
            }
            else 
            {
                header("Location:./login.php");
            }
        ?>
        <div class="col-sm-8">
            <form action="../functions/change_password_process.php" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Current Password</label>
                    <div class="col-sm-10">
                        <input class="acct_inp form-control-plaintext" name="passwd" placeholder="Current Password" type="password" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                        <input class="acct_inp form-control-plaintext" name="new_passwd" placeholder="New Password"  type="password" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Confirm New Password</label>
                    <div class="col-sm-10">
                        <input class="acct_inp form-control-plaintext" name="confirm_new_passwd" placeholder="Confirm New Password" required type="password" >
                    </div>
                </div>
                <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                    <input class="register_btn acct_btn" name="submit" type="submit" value="OK">
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
                </div>
            </form>
        </div>
    </div>
</div>
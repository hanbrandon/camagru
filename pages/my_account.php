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
            
            if ( !(isset($_SESSION['logged_in'])))
            { 
                header("Location:.?id=login.php");
            }
            else
            {   //okay session is true
                require_once './functions/get_user_info.php';
            
        ?>
        <div class="col-sm-8">
            <form action="../functions/change_email.php" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input class="acct_inp form-control-plaintext" name="username" placeholder="Username" type="text" value="<?php echo($usernameRow['username']); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input class="acct_inp form-control-plaintext" name="email" placeholder="Email" required type="email" value="<?php echo($usernameRow['email']); ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">New Email</label>
                    <div class="col-sm-10">
                        <input class="acct_inp form-control-plaintext" name="new_email" placeholder="New Email" type="email" >
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
        <?php
        }
        ?>
    </div>
</div>

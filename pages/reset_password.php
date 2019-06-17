<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<div class="reset_form">
	<form action="../functions/reset_password.php" method="post">
		<div class="login_box">
			<div class="login_field">
				<h1>Trouble Logging In?</h1>
				<input class="log_inp" name="email" placeholder="Email" required type="email">          
				<input class="login_btn" name="submit" type="submit" value="Send Reset Password Link">
				<p><a href="./?id=register.php">Create New Account</a> | <a href="./?id=login.php">Back To Login</a></p>
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
<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<div class="login_form">
	<form action="../functions/login_process.php" method="post">
		<div class="login_field">
				<h1>Login</h1>
				<input class="log_inp" name="username" placeholder="Username" required type="text">
				<input class="log_inp" name="passwd" placeholder="Password" required type="password">          
				<input class="login_btn" name="submit" type="submit" value="LOGIN">
				<p><a href="./?id=register.php">Register</a> | <a href="./?id=reset_password.php">Forgot password?</a></p>
				<span><?php 
				if (isset($_SESSION["error"]))
				{
					echo $_SESSION["error"]; 
					unset($_SESSION["error"]);
				}
				?></span>
		</div>
	</form>
</div>
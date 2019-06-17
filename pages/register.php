<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<div class="register_form">
	<form action="../functions/create.php" method="post">
		<h1>Register</h1>
		<input class="reg_inp" name="username" placeholder="Username" required type="text">
		<input class="reg_inp" name="passwd" placeholder="Password" required type="password">
		<input class="reg_inp" name="passwd_conf" placeholder="Re-Enter Password" required type="password">
		<input class="reg_inp" name="email" placeholder="Email" required type="email">                            
		<input class="register_btn" name="submit" type="submit" value="OK">
		<span>
			<?php 
				if (isset($_SESSION["error"]))
				{
					echo $_SESSION["error"]; 
					unset($_SESSION["error"]);
				}
			?>
		</span>
	</form>
</div>
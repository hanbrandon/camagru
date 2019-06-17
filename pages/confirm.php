<?php
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<div class="confirm_form">
	<form action="../functions/resend_email_verify.php" method="post">
		<h1>Thank you for Register</h1>
		<p>Please Check your Email to Verify your Email Address</p>
		<input class="register_btn" name="submit" type="submit" value="Re send email">
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
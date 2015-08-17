<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/phpass/PasswordHash.php";
	require_once "$root/template/Template.php";
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	if (!isset($_GET['user']))
	{
		echo generateTemplate('<div class="login" id="redirectnotice"> No user specified. If you suspect to have found a bug, please report this on the support page. </div>');
		die();
	}
	$visitor = 'anon';
	if (isset($_SESSION['user']))
		$visitor = $_SESSION['user'];
	$username = $_GET['user'];

	$email = 'user@mail.com';
	$profimgsrc = '/static/diamond_tiara_rawr.png';

	if ($visitor == $_GET['user'])
	{
		$template = "<div class=\"user\">
			<form action=\"/logout\">
				<div class=\"table\">
					<div class=\"row\">
						<div class=\"cell twenty\">
							To log out:
						</div>
						<div class=\"cell\">
							<input type=\"submit\" value=\"logout\">
						</div>
					</div>
					<div class=\"row\">
						<div class=\"cell twenty\">
							Username:
						</div>
						<div class=\"cell\">
							<input name=\"newname\" type=\"text\" value=\"$username\">
							<div class=\"elaboration\">
								Your publicly displayed name. All your posts and comments are visible under this name.
							</div>
						</div>
					</div>
					<div class=\"row\">
						<div class=\"cell twenty\">
							Password:
						</div>
						<div class=\"cell\">
							<input name=\"newpass1\" type=\"text\" value=\"\">
							<input name=\"newpass2\" type=\"text\" value=\"\">
							<div class=\"elaboration\">
								It's up to you to choose a strong password... To create a new password, write your passwords in both boxes.
							</div>
						</div>
					</div>
					<div class=\"row\">
						<div class=\"cell twenty\">
							Email:
						</div>
						<div class=\"cell\">
							<input name=\"newmail\" type=\"text\" value=\"$email\">
							<div class=\"elaboration\">
								We use this to send you a link to reset your password in case you lost your password.
							</div>
						</div>
					</div>
				</div>
				<div class=\"table\">
					<div class=\"row\">
						<div class=\"cell twenty\">
							Profile picture:
							<div class=\"elaboration\">
								The profile picture associated with your account. Remember that you can only choose pictures uploaded to this website.
							</div>
						</div>
						<div class=\"cell\">
							<input name=\"newpic\" type=\"text\" placeholder=\"35913\">
							<img alt=\"Profile Picture\" src=\"$profimgsrc\">
						</div>
					</div>
				</div>
				<div class=\"table\">
					<input type=\"submit\" value=\"save\">
				</div>
			</form>
		</div>";

		echo generateTemplate($template);
	}
	else
	{
		// Anyone viewing the public profile
	}
?>

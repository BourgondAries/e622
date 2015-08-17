<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";
	$sidebar = '';
	$redirect = '';
	if (isset($_GET['reason']))
	{
		switch ($_GET['reason'])
		{
			case 'upload':
			{
				$sidebar = '<div class="login" id="redirectnotice"> You were redirected here because you need to log in to upload. </div>';
				$redirect = '/upload';
			}
			break;
			case 'no_such_account':
			{
				$sidebar = '<div class="login" id="redirectnotice"> The account does not exist </div>';
				$redirect = '/upload';
			}
			break;
			case 'cannot_anon':
			{
				$sidebar = '<div class="login" id="redirectnotice"> Silly, you can\'t log in as anon. Anon is anon. You are you. Your life is your life. You started to brush. She\'s looking at you. You started to blush. Respect anon. </div>';
				$redirect = '/';
			}
			break;
			case 'wrong_password':
			{
				$sidebar = '<div class="login" id="redirectnotice"> The password is incorrect. </div>';
				$redirect = '/';
			}
			break;
			case 'already_logged_out':
			{
				$sidebar = '<div class="login" id="redirectnotice"> You tried logging out without being logged in. Maybe you want to log in. </div>';
				$redirect = '/';
			}
			break;

		}
	}
	$template = "<div class=\"login\">
		<div id=\"loginblock\">
			<div class=\"login-information\">
				LOGIN
			</div>
			<div class=\"largespacer\"> </div>
			<div class=\"information\">
				Click here to register a new account. Click here to reset your password.
			</div>
			<div class=\"largespacer\"> </div>
			<form id=\"loginform\" action=\"/loginuser/index.php?redirect=$redirect\" method=\"post\">
				<div id=\"tbusername\">
					<div class=\"tb\">
						Username
					</div>
					<div class=\"tb\">
						<input id=\"username\" name=\"username\" type=\"text\">
					</div>
				</div>
				<div class=\"fieldspacer\">
				</div>
				<div id=\"tbpassword\">
					<div class=\"tb\">
						Password
					</div>
					<div class=\"tb\">
						<input id=\"password\" name=\"password\" type=\"password\">
					</div>
				</div>
				<div id=\"button\">
					<input type=\"submit\" value=\"login\">
				</div>
			</form>
		</div>
	</div>";
	echo generateTemplate($template, $sidebar);
?>

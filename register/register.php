<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";

	$notice = '';
	if (isset($_GET['reason']))
	{
		switch ($_GET['reason'])
		{
			case 'user_already_exists':
				$notice = '<div id="redirectnotice" class="login">
					The user already exists, choose another username.
				</div>';
			break;
			case 'invalid_email':
				$notice = '<div id="redirectnotice" class="login">
					The email entered is invalid.
				</div>';
			break;
			case 'trailing_whitespace_username':
				$notice = '<div id="redirectnotice" class="login">
					The username contained trailing whitespace. Whitespace is only allowed between non-whitespace characters.
				</div>';
			break;
		}
	}

	$template = "<div class=\"login\">
		<div id=\"loginblock\">
			<div class=\"login-information\">
				REGISTER
			</div>
			<div class=\"largespacer\"> </div>
				<form id=\"loginform\" action=\"/register/registeruser.php\" method=\"post\">
					<div id=\"tbusername\">
						<div class=\"tb\">
							Username
						</div>
						<div class=\"tb\">
							<input id=\"username\" name=\"username\" type=\"text\">
						</div>
					</div>
					<div class=\"fieldspacer\"></div>
					<div id=\"tbpassword\">
						<div class=\"tb\">
							Password
						</div>
						<div class=\"tb\">
							<input id=\"password\" name=\"password\" type=\"password\">
						</div>
					</div>
					<div class=\"fieldspacer\"></div>
					<div id=\"tbusername\">
						<div class=\"tb\">
							Email
						</div>
						<div class=\"tb\">
							<input id=\"username\" name=\"email\" type=\"text\">
						</div>
					</div>
					<div class=\"fieldspacer\">
					<div id=\"button\">
						<input type=\"submit\" value=\"register\">
					</div>
				</form>
			</div>
		</div>
	</div>";

	echo generateTemplate($template, $notice);
?>

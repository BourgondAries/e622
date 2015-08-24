<?php
	class Register
	{
		static function renderInformation()
		{
			return self::$information;
		}

		private static $information = '<div class="smalltext">Your email is used to send you a password reset. Your password is securely hashed and salted, so we can not retrieve it. Your username must be unique. The username can be changed.</div><div class="space vertical"></div>';

		static function renderReason($reason)
		{
			switch ($reason)
			{
				case 'no_username': $reason = 'A request was made for a new account, but no username was given.'; break;
				case 'no_email': $reason = 'A request was made for a new account, but no email was given.'; break;
				case 'no_password': $reason = 'A request was made for a new account, but no password was given.'; break;
				case 'password_not_match': $reason = 'Your passwords do not match.'; break;
				case 'name_too_short': $reason = 'The username ought to be at least three characters long.'; break;
				case 'name_trailing_spaces': $reason = 'Trailing spaces are not allowed in the username.'; break;
				case 'password_empty': $reason = 'Your password must not be empty.'; break;
				case 'invalid_email': $reason = 'The email used does not appear to be valid.'; break;
				case 'username_exists': $reason = 'The username you are trying to register already exists.'; break;

				case 'email_exists': $reason = 'The email address is already used. If you lost your password <a href="/reset"> click here </a>'; break;
				case 'unable_to_insert': $reason = 'For some reason, we were unable to create your user in this specific moment. Try again later or contact support.'; break;
				case null: return ''; break;
			}
			return self::$reason_code[0] . $reason . self::$reason_code[1];
		}

		static function render($username, $email)
		{
			return self::$code[0] . $username . self::$code[1] . $email . self::$code[2];
		}

		static $reason_code =
		[
			'<div class="warning">',

			'</div>'
		];

		static private $code =
		[
			'<div class="row">
				REGISTER
			</div>
			<div class="row">
				<span class="smalltext">
					We suggest using a password manager and to autogenerate the password with more than twenty characters.
				</span>
			</div>
			<form action="/checkregister" method="post">
				<div class="autotable">
					<div class="auto table-column"></div>
					<div class="tiny table-column"></div>
					<div class="max table-column"></div>
					<div class="row"><div class="vertical space"></div></div>
					<div class="row">
						<div class="cell">
							Username
						</div>
						<div class="cell"></div>
						<div class="cell">
							<input class="searchbar" name="username" placeholder="This is my username" type="text" value="',

							'">
						</div>
					</div>
					<div class="row"><div class="vertical space"></div></div>
					<div class="row">
						<div class="cell">
							Email
						</div>
						<div class="cell"></div>
						<div class="cell">
							<input class="searchbar" name="email" placeholder="xXxN00bKill4r94oOo@rektmail.com" type="text" value="',

							'">
						</div>
					</div>
					<div class="row"><div class="vertical space"></div></div>
					<div class="row">
						<div class="cell">
							Password
						</div>
						<div class="cell"></div>
						<div class="cell">
							<div class="table">
								<div class="row">
									<input class="searchbar" name="password" placeholder="type your password" type="password">
								</div>
								<div class="row"><div class="vertical space"></div></div>
								<div class="row">
									<input class="searchbar" name="password_retype" placeholder="retype your password" type="password">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row"><div class="vertical space"></div></div>
				<input type="submit" value="register">
			</form>'
		];
	}
?>

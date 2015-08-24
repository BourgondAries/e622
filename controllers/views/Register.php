<?php
	class Register
	{
		static function renderReason($reason)
		{
			switch ($reason)
			{
				case 'email_used':
					$reason = 'The email address is already used. If you lost your password <a href="reset"> click here </a>';
				break;
				case null:
					return null;
				break;
			}
			return $reason_code[0] . $reason . $reason_code[1];
		}

		static function render()
		{
			return self::$code;
		}

		static $reason_code =
		[
			'<div class="warning">',

			'</div>'
		];

		static private $code = '<div class="box">
				<div class="boxpad">
					<div class="row">
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
							<div class="row">
								<div class="cell">
									Username
								</div>
								<div class="cell"></div>
								<div class="cell">
									<input class="searchbar" name="username" placeholder="This is my username" type="text">
								</div>
							</div>
							<div class="row">
								<div class="cell">
									Email
								</div>
								<div class="cell"></div>
								<div class="cell">
									<input class="searchbar" name="email" placeholder="xXxN00bKill4r94oOo@rektmail.com" type="text">
								</div>
							</div>
							<div class="row">
								<div class="cell">
									Password
								</div>
								<div class="cell"></div>
								<div class="cell">
									<div class="table">
										<div class="row">
											<input class="searchbar" name="password" type="password">
										</div>
										<div class="row">
											<input class="searchbar" name="password_retype" type="password">
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="submit" value="register">
					</form>
				</div>
			</div>';
	}
?>

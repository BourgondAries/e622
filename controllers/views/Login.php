<?php
	class Login
	{
		static function renderReason($reason)
		{
			switch ($reason)
			{
				case 'wrong_password':
					$reason = 'The password is incorrect';
				break;
				case 'invalid_user':
					$reason = 'The user does not exist, maybe you should create an account!';
				break;
				case 'account_suspended':
					$reason = 'The account is currently suspended';
				break;
			}
			return Login::$reason_code[0] . $reason . Login::$reason_code[1];
		}

		static function render()
		{
			return Login::$code;
		}

		static private $reason_code =
		['<div class="warning">',

			'</div>'
		];

		static private $code = '<div class="box">
				<div class="boxpad">
					<div class="row">
						LOGIN
					</div>
					<div class="row">
						<span class="smalltext"> <a href="register"> Click here </a> to register an account. <a href="reset"> Click here </a> to reset your password. </span>
					</div>
					<form action="/checklogin" method="post">
						<div class="table">
							<div class="row">
								<div class="cell">
									Username
								</div>
								<div class="cell">
									<input class="searchbar" type="text">
								</div>
							</div>
							<div class="row">
								<div class="cell">
									Password
								</div>
								<div class="cell">
									<input class="searchbar" type="password">
								</div>
							</div>
						</div>
						<input type="submit" value="log in">
					</form>
				</div>
			</div>';
	}
?>

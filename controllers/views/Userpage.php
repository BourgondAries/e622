<?php
	class Userpage
	{
		static function renderNotExist($username)
		{
			return self::$code_not_exist[0] . $username . self::$code_not_exist[1];
		}

		static private $code_not_exist =
		[
			'<div class="warning"> The user "',

			'" does not exist.</div>'
		];

		static function renderPrivilegedStatistics()
		{
			return self::$statistics[0];
		}

		static private $statistics =
		[
			'<div class="smalltext"> Here you can change your settings
			and see some statistics. </div>
			<div class="space vertical"></div>
			<form action="/logout" method="post">
				<input type="submit" value="log out">
			</form>'
		];

		static function renderPrivileged($username, $email)
		{
			return self::$code[0] . $username . self::$code[1] . $email . self::$code[2];
		}

		static private $code =
		[
			' <div class="row">
						USER PAGE
					</div>
					<form action="/changeuser" method="post">
						<div class="autotable">
							<div class="auto table-column"></div>
							<div class="tiny table-column"></div>
							<div class="max table-column"></div>
							<div class="row">
								<div class="cell">
									Username
								</div>
								<div class="cell">
								</div>
								<div class="cell">
									<input class="searchbar" name="username" placeholder="',

									'" type="text">
								</div>
							</div>
							<div class="row">
								<div class="cell">
									Email
								</div>
								<div class="cell">
								</div>
								<div class="cell">
									<input class="searchbar" name="email" placeholder="',

									'" type="text">
								</div>
							</div>
							<div class="row">
								<div class="cell">
									Password
								</div>
								<div class="cell">
								</div>
								<div class="cell">
									<input name="password" type="password">
								</div>
							</div>
							<div class="row">
								<div class="cell">
									Re-type password
								</div>
								<div class="cell">
								</div>
								<div class="cell">
									<input name="password_retype" type="password">
								</div>
							</div>
						</div>
						<div class="space vertical"></div>
						<input type="submit" value="update">
					</form>'
		];
	}
?>

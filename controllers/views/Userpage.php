<?php
	class Userpage
	{
		static function renderPrivileged($username, $email)
		{
			return self::$code[0] . $username . self::$code[1] . $email . self::$code[2];
		}

		static private $code =
		[
			'<div class="box">
				<div class="boxpad">
					<div class="row">
						USER PAGE
					</div>
					<form action="/changeuser" method="post">
						<div class="table">
							<div class="row">
								<div class="cell">
									Username
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
									<input class="searchbar" name="email" placeholder="',

									'" type="text">
								</div>
							</div>
						</div>
						<input type="submit" value="log in">
					</form>
				</div>
			</div>'
		];
	}
?>

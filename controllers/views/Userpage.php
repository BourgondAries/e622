<?php
	require_once 'utils/StringManip.php';
	class Userpage
	{
		static function renderNotExist($username)
		{
			return self::$code_not_exist[0] . $username . self::$code_not_exist[1];
		}

		static function renderNoPrivilege($username)
		{
			return intermix(self::$code_not_privileged, [$username]);
		}

		static function renderSuccessTime($time)
		{
			return self::$success_box[0] . $time . self::$success_box[1];
		}

		static private $success_box =
		[
			'<div class="vertical space"></div>
			<div class="notification">
				Successfully changed the user at: ',

			'</div>'
		];

		static function renderReason($reason)
		{
			switch ($reason)
			{
				case 'privilege_required': $reason = 'You do not have the privilege to change these settings.'; break;
				case 'username_too_long': $reason = 'The username is too long. It must not exceed 26 characters.'; break;
				case 'name_too_short': $reason = 'The name to change to is too short. A username must be at least three characters long.'; break;
				case 'name_trailing_spaces': $reason = 'A username can not contain trailing spaces. Spaces within the words is just fine.'; break;
				case 'invalid_email': $reason = 'The email that was specified is not valid.'; break;
				case 'username_already_exists': $reason = 'The username you\'re trying to change to already exists somewhere.'; break;
				case 'email_exists': $reason = 'Another account is already using this email. Emails must be unique.'; break;
				case 'old_pass_error': $reason = 'The old password was incorrect, nothing is changed.'; break;
				case 'unable_to_insert':
				case 'no_result': $reason = 'No result could be fetched. Try again later or contact support.'; break;
				case null:
				default:
					return '';
			}
			return self::$warning_box[0] . $reason. self::$warning_box[1];
		}

		static private $warning_box =
		[
			'<div class="vertical space"></div><div class="warning">',

			'</div>'
		];

		static private $code_not_exist =
		[
			'<div class="warning"> The user "',

			'" does not exist.</div>'
		];

		static private $code_not_privileged =
		[
			'<div class="warning"> The user "',

			'" can not be shown to you, you have insufficient privileges.</div>'
		];

		static function renderPrivilegedStatistics()
		{
			return self::$statistics[0];
		}

		static function renderNothingChanged()
		{
			return intermix(self::$nothing_changed, ['No visible changes made.']);
		}

		static private $nothing_changed =
		[
			'<div class="vertical space"></div>
			<div class="suspicion">',

			'</div>'
		];

		static private function renderPrivilegeButtons($privileges, $privilege, $viewer_privilege, $views_self)
		{
			$keys = '';
			foreach ($privileges as &$privilege_set)
			{
				$status = '';
				if ($privilege_set['privilege_id'] == $privilege)
					$status = 'selected';
				else if ($privilege_set['privilege_id'] <= $viewer_privilege && $views_self == false || $privilege_set['privilege_id'] < $viewer_privilege && $views_self == true)
					$status = 'disabled';

				$description = $privilege_set['description'];
				$id = $privilege_set['privilege_id'];
				$keys .= intermix(self::$privilege_template, [$id, $status, $description]);
			}
			return $keys;
		}

		static private $privilege_template =
		[
			'<option value="',
			'" ',
			'>',
			'</option>'
		];

		static private $statistics =
		[
			'<div class="smalltext"> Here you can change your settings
			and see some statistics. </div>
			<div class="space vertical"></div>
			<form action="/logout" method="post">
				<input type="submit" value="log out">
			</form>
			'
		];

		static function renderPrivileged($username, $email, $privileges, $userprivilege, $viewer_privilege, $viewername)
		{
			$privilege_buttons = self::renderPrivilegeButtons($privileges, $userprivilege, $viewer_privilege, $username == $viewername);
			$oldpassfield = '';
			if ($viewername == $username)
				$oldpassfield = self::$old_pass_entry;
			return intermix(self::$code, [$username, $username, $email, $oldpassfield, $privilege_buttons]);
		}

		static private $old_pass_entry = '
			<div class="row"><div class="vertical space"></div></div>
				<div class="row">
					<div class="cell text">
						Old Password
					</div>
					<div class="cell">
					</div>
					<div class="cell">
						<input name="old_password" placeholder="required for security reasons" type="password">
					</div>
				</div>';

		static private $code =
		[
			' <div class="row">
						USER PAGE
					</div>
					<form action="/changeuser/',

					'" method="post">
						<div class="autotable">
							<div class="auto table-column"></div>
							<div class="tiny table-column"></div>
							<div class="max table-column"></div>
							<div class="row"><div class="vertical space"></div></div>
							<div class="row">
								<div class="cell">
									Username
								</div>
								<div class="cell">
								</div>
								<div class="cell">
									<input name="username" value="',

									'" type="text">
								</div>
							</div>
							<div class="row"><div class="vertical space"></div></div>
							<div class="row">
								<div class="cell">
									Email
								</div>
								<div class="cell">
								</div>
								<div class="cell">
									<input name="email" value="',

									'" type="text">
								</div>
							</div>',

							'<div class="row"><div class="vertical space"></div></div>
							<div class="row">
								<div class="cell text">
									New Password
								</div>
								<div class="cell">
								</div>
								<div class="cell">
									<input name="password" placeholder="no password change" type="password">
								</div>
							</div>
							<div class="row"><div class="vertical space"></div></div>
							<div class="row">
								<div class="cell text">
									Re-type password
								</div>
								<div class="cell">
								</div>
								<div class="cell">
									<input name="password_retype" placeholder="no password change" type="password">
								</div>
							</div>
							<div class="row"><div class="vertical space"></div></div>
							<div class="cell"> Privilege </div>
							<div class="cell"></div>
							<div class="cell">
								<select name="privilege">
								',

								'
								</select>
							</div>
						</div>
						<div class="space vertical"></div>
						<input type="submit" value="update">
					</form>'
		];
	}
?>

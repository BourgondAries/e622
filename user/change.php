<?php
	function clearAll()
	{
		session_start();
		session_unset();
		session_destroy();
		header('Location: ' . '/');
		die();
	}

	if (session_status() == PHP_SESSION_NONE)
		session_start();

	if (!isset($_POST))
		clearAll();
	switch ($_POST['button'])
	{
		case 'logout':
		{
			clearAll();
		}
		break;
		case 'save':
		{
			if (isset($_SESSION['user']))
			{
				// Change the user entry in db
				$username = $_SESSION['user'];
				$root = $_SERVER['DOCUMENT_ROOT'];
				require_once "$root/utils/E621.php";
				require_once "$root/phpass/PasswordHash.php";
				$pwcheck = new PasswordHash(8, false);
				$db = new E621;
				$dbc = $db->get();
				if ($_POST['newname'] != $_SESSION['user'])
				{
					$dbc->autocommit(true);
					$prepstmt = $dbc->prepare('UPDATE User SET username = ? WHERE username = ?;');
					$prepstmt->bind_param('ss', $_POST['newname'], $_SESSION['user']);
					$affected = $prepstmt->execute();
					if ($affected == 0)
					{
						echo 'Could not change username';
						die();
					}
					$_SESSION['user'] = $_POST['newname'];
				}
				if ($_POST['newpass1'] != '')
				{
					if ($_POST['newpass1'] == $_POST['newpass2'])
					{
						$pwhash = $pwcheck->HashPassword($_POST['newpass1']);
						$dbc->autocommit(true);
						$prepstmt = $dbc->prepare('UPDATE User SET password_hash = ? WHERE username = ?;');
						$prepstmt->bind_param('ss', $pwhash, $_SESSION['user']);
						$affected = $prepstmt->execute();
					}
					else
					{
						header('Location: ' . "/user/user.php?user=${_SESSION['user']}&reason=passwords_dont_match");
						die();
					}
				}
				if ($_POST['newpic'] != '')
				{
					$dbc->autocommit(false);
					$prep = $dbc->prepare('SELECT UserProfileMedia.user_ID FROM UserProfileMedia JOIN User ON UserProfileMedia.user_ID = User.user_ID WHERE username = ?;');
					$prep->bind_param('i', $_SESSION['user']);
					$prep->execute();
					$res2 = $prep->get_result();
					$uid = $res2->fetch_array();

					while ($res2->fetch_array());

					$prep = $dbc->prepare('SELECT user_ID FROM User WHERE username = ?;');
					$prep->bind_param('s', $_SESSION['user']);
					$prep->execute();
					$res2 = $prep->get_result();
					$userid = $res2->fetch_array()[0];

					while ($res2->fetch_array());

					if (!$uid)
					{
						$prep = $dbc->prepare('INSERT INTO UserProfileMedia (profile_pic_ID, user_ID) VALUES (?, ?);');
						$prep->bind_param('ii', $_POST['newpic'], $userid);
						$prep->execute();
					}
					else
					{
						$prep = $dbc->prepare('UPDATE UserProfileMedia SET profile_pic_ID = ? WHERE user_ID = ?;');
						var_dump($prep);
						$prep->bind_param('ii', $_POST['newpic'], $userid);
						$prep->execute();
					}
				}
				$dbc->autocommit(true);
				$prepstmt = $dbc->prepare('UPDATE User SET email = ? WHERE username = ?;');
				$prepstmt->bind_param('ss', $_POST['newmail'], $_SESSION['user']);
				$affected = $prepstmt->execute();

				header('Location: ' . "/user/user.php?user=${_SESSION['user']}");
				die();
			}
			else
				header('Location: ' . '/login/index.php?reason=already_logged_out');
		}
		break;
	}
?>

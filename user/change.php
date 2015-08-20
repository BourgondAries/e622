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

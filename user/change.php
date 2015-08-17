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
				header('Location: ' . "/user/user.php?user=dsa");
				die();
			}
			else
				header('Location: ' . '/login/index.php?reason=already_logged_out');
		}
		break;
	}
?>

<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/phpass/PasswordHash.php";
	require_once "$root/template/Template.php";
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	if (!isset($_GET['user']))
	{
		echo generateTemplate('<div class="login" id="redirectnotice"> No user specified. If you suspect to have found a bug, please report this on the support page. </div>');
		die();
	}
	$visitor = 'anon';
	if (isset($_SESSION['user']))
		$visitor = $_SESSION['user'];

	if ($visitor == $_GET['user'])
	{
		// The user looking at his own profile
	}
	else
	{
		// Anyone viewing the public profile
	}
	$template = "<form action=\"/logout\">
		<input type=\"submit\" value=\"logout\">
	</form>";

	echo generateTemplate($template);
?>

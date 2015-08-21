<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	if (!isset($_SESSION) || !isset($_SESSION['user']))
	{
		header('Location: ' . '/login');
		die();
	}
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/utils/E621.php";
	$db = new E621;
	$con = $db->get();

	$prep = $con->prepare('SELECT user_ID FROM User WHERE username = ?;');
	$prep->bind_param('s', $_SESSION['user']);
	$prep->execute();
	$res2 = $prep->get_result();
	$userid = $res2->fetch_array(MYSQLI_NUM)[0];

	echo $_POST['commentwhere'];
	$prep = $con->prepare('INSERT INTO Comment (user_ID, media_ID, comment) VALUES (?, ?, ?);');
	$comment = $_POST['comment'];
	$prep->bind_param('iis', $userid, $_POST['commentwhere'], $comment);
	if (!$prep->execute())
	{
		echo 'Failed to execute!';
		echo $con->error;
	}
	$con->commit();
	header('Location: /media/media.php?id=' . $_POST['commentwhere']);
?>

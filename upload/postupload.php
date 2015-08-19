<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	if (!isset($_SESSION['user']))
	{
		header('Location: ' . '/login/index.php?reason=upload_expired');
		die();
	}
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/utils/E621.php";
	function makeTagIds($tag_list)
	{
	}
	var_dump($_POST);
	$tag_array = explode(' ', $_POST['tags']);
	$description = $_POST['description'];
	$tmpname = $_FILES['file']['tmp_name'];
	$check = getimagesize($tmpname);
	$extension = '';
	if ($check !== false)
	{
		$mime = $check['mime'];
		echo $mime;
		switch ($mime)
		{
			case 'image/jpeg':
				$extension = 'jpeg';
			break;
			case 'image/png':
				$extension = 'png';
			break;
			default:
			break;
		}
		$db = new E621;
		$db_conn = $db->get();

		$failed = false;
		$mysqli = $db->get();
		$mysqli->autocommit(false);
		$res = $mysqli->query("SELECT max(media_ID) as mx FROM Media");
		$max = $res->fetch_object();
		$assoc_file = base_convert($max->mx + 1, 10, 36) . '.' . $extension;
		$full_path = "$root/media_store/$assoc_file";
		rename($tmpname, $full_path);

		$prepst = $mysqli->prepare("INSERT INTO Media (filename, description, uploader) VALUES (?, ?, ?);");
		$prepst->bind_param('ssi', $assoc_file, $description, $num);
		$prepst->execute();

		$mysqli->commit();
		die();

		$failed ? $mysqli->rollback() : $mysqli->commit();

		$db_conn_getter = $db_conn->prepare('SELECT max(media_ID) FROM Media');
		$db_conn_getter->execute();
		$result = $db_conn_prep->get_result();
		$fetched = $result->fetch_array(MYSQLI_NUM);
		var_dump($fetched);
		die();

		$db_conn_prep = $db_conn->prepare('INSERT INTO Media (description, );');
		$db_conn_prep->bind_param('s', $username);
		$does_exist = $db_conn_prep->execute();
		$result = $db_conn_prep->get_result();
		$fetched = $result->fetch_array(MYSQLI_NUM);
	}
	else
		echo 'not img';
	var_dump($_FILES);
?>

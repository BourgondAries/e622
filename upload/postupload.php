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

		// Find the user id first
		$prepst = $mysqli->prepare("SELECT user_ID FROM User WHERE username=?");
		$prepst->bind_param('s', $_SESSION['user']);
		$res = $prepst->execute();
		$res2 = $prepst->get_result();
		$fetched = $res2->fetch_array(MYSQLI_NUM);
		$userid = $fetched[0];

		$res = $mysqli->query("SELECT max(media_ID) as mx FROM Media");
		$max = $res->fetch_object();
		$assoc_file = base_convert($max->mx + 1, 10, 36) . '.' . $extension;
		$full_path = "$root/media_store/$assoc_file";
		rename($tmpname, $full_path);

		$prepst = $mysqli->prepare("INSERT INTO Media (filename, description, uploader) VALUES (?, ?, ?);");
		$prepst->bind_param('ssi', $assoc_file, $description, $userid);
		$prepst->execute();
		foreach ($tag_array as &$tag)
		{
			$tagprep = $mysqli->prepare('INSERT IGNORE INTO Tag (description) VALUES (?);');
			$tagprep->bind_param('s', $tag);
			$tagprep->execute();
		}

		$mysqli->commit();

		$placing = 0;
		$imgid = $max->mx + 1;
		foreach ($tag_array as &$tag)
		{
			$res = $mysqli->prepare('SELECT tag_ID FROM Tag WHERE description = ?;');
			$res->bind_param('s', $tag);
			$res->execute();
			$result = '';
			$res->bind_result($result);
			while ($res->fetch());

			$res = $mysqli->prepare('INSERT INTO MediaTag (tag_ID, media_ID, placing, responsible_user_id) VALUES (?, ?, ?, ?);');
			$res->bind_param('iiii', $result, $imgid, $placing, $userid);
			$res->execute();
			++$placing;
		}
		$mysqli->commit();
		header('Location: ' . '/upload');
	}
	else
		echo 'not img';
	var_dump($_FILES);
?>

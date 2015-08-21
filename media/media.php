<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";
	require_once "$root/utils/E621.php";
	require_once "mediadescriber/Describer.php";
	require_once 'leftbar/PropertyGenerator.php';

	$db = new E621;
	$mysqli = $db->get();

	$prepst = $mysqli->prepare("SELECT filename, description, source, upload_date FROM Media WHERE media_ID = ?;");
	$prepst->bind_param('i', $_GET['id']);
	$res = $prepst->execute();
	$res2 = $prepst->get_result();
	$fetched = $res2->fetch_array(MYSQLI_NUM);
	$file = $fetched[0];
	$description = $fetched[1];
	$source = $fetched[2];
	$upload_date = $fetched[3];

	$prepst = $mysqli->prepare("SELECT description FROM MediaTag JOIN Tag ON MediaTag.tag_ID = Tag.tag_ID WHERE media_ID = ? ORDER BY placing ASC;");
	$prepst->bind_param('i', $_GET['id']);
	$res = $prepst->execute();
	$res2 = $prepst->get_result();
	$fetched = $res2->fetch_array(MYSQLI_NUM);
	$tag_list = [];
	while ($fetched)
	{
		$tag_list[] = $fetched[0];
		$fetched = $res2->fetch_array(MYSQLI_NUM);
	}

	$prepst = $mysqli->prepare("SELECT User.user_ID, comment, comm_date as date, username as user FROM Comment JOIN User ON User.user_ID = Comment.user_ID WHERE media_ID = ? ORDER BY comm_date DESC;");
	$prepst->bind_param('i', $_GET['id']);
	$res = $prepst->execute();
	$res2 = $prepst->get_result();
	$fetched = $res2->fetch_assoc();
	$comment_list = [];

	while ($fetched)
	{
		$comment_list[] = $fetched;
		$fetched = $res2->fetch_assoc();
	}

	foreach ($comment_list as &$comment)
	{
		$prepst = $mysqli->prepare('SELECT filename FROM UserProfileMedia JOIN Media ON Media.media_ID = profile_pic_ID WHERE user_ID = ?;');
		$prepst->bind_param('i', $comment['user_ID']);
		$res = $prepst->execute();
		$res2 = $prepst->get_result();
		$fetched = $res2->fetch_assoc();
		$comment['profilepic'] = '/media_store/' . $fetched['filename'];
	}

	$result = describeMedia
	(
		"/media_store/$file",
		'',
		$tag_list,
		$comment_list,
		$description,
		$_GET['id']
	);

	$leftbar = generateSidebarProperties(2, 1, 0, "SFW");

	echo generateTemplate($result, $leftbar);
?>

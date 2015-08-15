<!DOCTYPE html>
<html>
	<head>
		<title>e622 - World's Most Open Database</title>
		<link rel="stylesheet" type="test/css" href="style/cat.css">
	</head>

	<body>
		<div class="navbar">
			<div id="navbar">
				<ul>
					<li><a href="#login">Login</a></li>
					<li><a href="#tags">Tags</a></li>
					<li><a href="#news">News</a></li>
					<li><a href="#update">Update</a></li>
				</ul>
			</div>
		</div>

		<?php
			$root = $_SERVER['DOCUMENT_ROOT'];
			include "$root/utils/News.php";
		?>

		<?php

		?>

<?php
	require_once 'result/Result.php';
	$item = array(
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW'),
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW')
	);
	echo generateResult($item);
?>
	</body>
</html>

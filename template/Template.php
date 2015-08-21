<?php
	require_once 'search/SearchBar.php';
	function generateTemplate($mainpage = '', $sidebar = '', $title = 'e622 - World\'s Most Open Database')
	{
		$root = $_SERVER['DOCUMENT_ROOT'];
		include_once "$root/utils/News.php";
		$news = generateNews();
		$searchbar = generateSearchBar();

		if (session_status() == PHP_SESSION_NONE)
			session_start();

		$login_or_username = 'LOGIN';
		$login_or_userpage = '/login';
		if (isset($_SESSION['user']))
		{
			$login_or_username = $_SESSION['user'];
			$login_or_userpage = '/user/user.php?user=' . $login_or_username;
		}

		return "<!DOCTYPE html>
		<html>
			<head>
				<title>$title</title>
				<link rel=\"icon\" type=\"image/png\" href=\"/favicon.png?v=3\">
				<link rel=\"stylesheet\" type=\"test/css\" href=\"/style/cat.css\">
				<link rel=\"stylesheet\" type=\"test/css\" href=\"/style/tags.css\">
				<script>
					// setTimeout(function() {
					//	 window.location.reload(1);
					// }, 2000);
				</script>
			</head>

			<body>
				<div class=\"navbar\">
					<div id=\"navbar\">
						<ul>
							<li><a href=\"/\">e622</a></li>
							<li><a href=\"$login_or_userpage\">$login_or_username</a></li>
							<li><a href=\"/tags\">Tags</a></li>
							<li><a href=\"/upload\">Upload</a></li>
							<li><a href=\"/help\">Help</a></li>
							<li><a href=\"/support\">Support</a></li>
						</ul>
					</div>
				</div>

				$news

				<div class=\"searchblock\">
					<div id=\"searchcontainer\">
						<div id=\"searchbar\">
							$searchbar
							<div id=\"extra\">
								$sidebar
							</div>
						</div>
						<div id=\"result\">
							$mainpage
						</div>

					</div>
				</div>
			</body>
		</html>";
	}
?>

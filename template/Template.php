<?php
	function generateTemplate($mainpage = '', $sidebar = '', $title = 'e622 - World\'s Most Open Database')
	{
		$root = $_SERVER['DOCUMENT_ROOT'];
		include_once "$root/utils/News.php";
		$news = generateNews();

		return "<!DOCTYPE html>
		<html>
			<head>
				<title>$title</title>
				<link rel=\"stylesheet\" type=\"test/css\" href=\"style/cat.css\">
			</head>

			<body>
				<div class=\"navbar\">
					<div id=\"navbar\">
						<ul>
							<li><a href=\"#login\">Login</a></li>
							<li><a href=\"#tags\">Tags</a></li>
							<li><a href=\"#news\">News</a></li>
							<li><a href=\"#update\">Update</a></li>
						</ul>
					</div>
				</div>

				$news

				<div class=\"searchblock\">
					<div id=\"searchcontainer\">
						<div id=\"searchbar\">
							$sidebar
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

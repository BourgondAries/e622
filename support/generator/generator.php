<?php
	function generateSupportPage($comments)
	{
		$root = $_SERVER['DOCUMENT_ROOT'];
		require_once 'comment/commentgenerator.php';
		require_once "$root/template/Template.php";

		$all_comments = '';
		foreach ($comments as &$comment)
			$all_comments .= generateComment($comment);

		$template = "<div class=\"help\">
			<div id=\"helpblock\">
				<div class=\"information\">
					e622 is created by two university students: BourgondAries and [REDACTED]. A simple rewrite and more free content system than e621. e622 allows you to search for more tags than e621, as well as being a content host for any type of content. Go check out e621 btw, it's awesome and has been a great inspiration for e622! The code for e622 is freely available on github. e622 is free software. Free as in freedom, not free beer.
					Write your complaints, compliments *blush*, criticism and ideas here! We (the webadmins) will read these and probably respond.
					<div class=\"vertspacer\">
						<div class=\"mediadescriptor\">
							$all_comments
						</div>
					</div>
				</div>
			</div>
		</div>";
		return $template;
	}
?>

<?php
	function generateComment($comment)
	{
		$template = "<div class=\"commentencapsulator\">
			<div class=\"comment\">
				<div class=\"commentowner\">
					<div class=\"inner\">
						${comment['user']}
						<img src=\"${comment['profilepic']}\">
					</div>
				</div>
				<div class=\"commentcontain\">
					${comment['comment']}
				</div>
			</div>
		</div>";
		return $template;
	}
?>

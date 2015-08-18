<?php
	function generateComment($comment)
	{
		$template = "<div class=\"commentencapsulator\">
			<div class=\"comment\">
				<div class=\"commentowner\">
					<div class=\"inner\">
						<div class=\"user\">
							${comment['user']}
						</div>
						<div class=\"commentdate\">
							${comment['date']}
						</div>
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

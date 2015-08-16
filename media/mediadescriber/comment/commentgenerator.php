<?php
	function generateComment($comment)
	{
		$template = "<div class=\"commentencapsulator\">
			<div class=\"comment\">
				<div class=\"commentowner\">
					${comment['user']}
				</div>
				<div class=\"commentcontain\">
					${comment['comment']}
				</div>
			</div>
		</div>";
		return $template;
	}
?>

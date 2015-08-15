<?php
	function generateComment($comment)
	{
		$template = "<div class=\"commentencapsulator\">
			<div class=\"comment\">
				${comment['comment']}
			</div>
		</div>";
		return $template;
	}
?>

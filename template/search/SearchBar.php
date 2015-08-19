<?php
	function generateSearchBar()
	{
		return '<div class="searchbar">
				<span id="searchblock"> Search </span> <span id="options"> <a href="/help">(search options)</a></span>
				<form action="/search.php">
					<input id="textfield" type="text" name="q">
					<input type="submit" value="Submit"
						style="position: absolute; left: -100%; width: 1px; height: 1px;">
				</form>
			</div>';
	}
?>

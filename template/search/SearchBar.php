<?php
	function generateSearchBar()
	{
		return '<div class="searchbar">
				<h5 id="searchblock"> Search </h5>
				<form action="/search.php">
					<input id="textfield" type="text" name="q">
					<input type="submit" value="Submit"
						style="position: absolute; left: -100%; width: 1px; height: 1px;">
				</form>
			</div>';
	}
?>

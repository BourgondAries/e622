<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once("$root/utils/stylelink.php")
?>
<div class="searchblock">
	<div id="searchcontainer">
		<div id="searchbar">
			<?php
				require_once 'search/SearchBar.php';
			?>
		</div>
		<div id="result">
			<?php
				require_once 'resgen/ResultSet.php';
			?>
		</div>
	</div>
</div>

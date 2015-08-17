<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";

	$template = "<div class=\"help\">
		<div id=\"helpblock\">
			<div class=\"information\">
				e622 is created by two university students: BourgondAries and [REDACTED]. A simple rewrite and more free content system than e621. e621 allows you to search many more tags, as well as providing a content host for any type of content. Go check out e621 btw, it's awesome! The code for e622 is freely available on github. e622 is free software. Free as in freedom, not free beer.
				Write your complaints, compliments *blush*, criticism and ideas here! We (the webadmins) will read these and probably respond.
			</div>
		</div>
	</div>";
	$donate = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="QVYZKKGJVC8JS">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/no_NO/i/scr/pixel.gif" width="1" height="1">
	</form>';
	$support = "<div class=\"support donate\">
		If you want to support e622, leave some feedback about potential improvements. A donation is also always welcome.
		<div class=\"support donatebutton\">
			$donate
		</div>
	</div>";
	echo generateTemplate($template, $support);
?>

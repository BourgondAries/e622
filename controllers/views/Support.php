<?php
	include_once "utils/StringManip.php";
	class Support
	{

		private static $donate = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="YU8STHSM2CRK4">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/no_NO/i/scr/pixel.gif" width="1" height="1">
			</form>';

		static function getBar()
		{
			return self::$donate;
		}

		static function getText()
		{
			return '
				<div class="table">
					<div class="small table-column"></div>
					<div class="auto table-column"></div>
					<div class="small table-column"></div>
					<div class="row">
						<div class="cell"> </div>
						<div class="cell">
							The server is an expensive machine to pay for. Power, hosting, domain, maintenance, and the occasional fix all require time and money. I\'ll try to keep this system up for as long as I can, because I love imageboorus. However, with your help it will be possible to do so much more.
						</div>
						<div class="cell"> </div>
					</div>
				</div>
			';
		}

	}
?>

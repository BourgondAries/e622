<?php
	require_once 'utils/StringManip.php';
	class MediaPage
	{
		static function render($media_data)
		{
			return intermix(self::$code, [$media_data['filename']]);
		}

		static private $code =
		[
			'<img src="/storage/',

			'">'
		];
	}
?>

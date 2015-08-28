<?php
	require_once 'utils/StringManip.php';
	class Thumbnail
	{
		static function generateThumbnails($list)
		{
			$html = '';
			foreach ($list as &$list_elem)
				$html .= self::generateThumbnail($list_elem);
			return $html;
		}

		static function generateThumbnail($item)
		{
			return intermix(self::$code, [$item['filename']]);
		}

		static private $code =
		[
			'<img style="max-height: 25vh; max-width: 18vw;" src="/storage/',

			'_200.png"><div style="display: inline-block;" class="horizontal space"></div>'
		];
	}
?>

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
			return intermix(self::$code, [$item['filename'], getExtension($item['filename'])]);
		}

		static private $code =
		[
			'<div class="thumbnailbox">
				<img class="thumbnail" src="/storage/',

				'_200.',

				'">
				<div class="thumbnailbar">
					<div class="smalltext">
						Damn son
					</div>
				</div>
				<div class="vertical space">
				</div>
			</div>
			<div class="horizontal space"></div>'
		];
	}
?>

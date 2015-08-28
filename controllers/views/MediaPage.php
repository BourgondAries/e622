<?php
	require_once 'utils/StringManip.php';
	class MediaPage
	{
		static function render($media_data)
		{
			if (getExtension($media_data['filename']) == 'webm')
				return intermix(self::$video_code, [$media_data['filename']]);
			else
				return intermix(self::$code, [$media_data['filename']]);
		}

		static private $video_code =
		[
			'<video class="media" controls>
				<source src="/storage/',

				'" type="video/webm">
			</video>'
		];

		static private $code =
		[
			'<img class="media" src="/storage/',

			'">'
		];
	}
?>

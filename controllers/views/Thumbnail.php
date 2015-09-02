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
			$stats = self::generateStats($item['ups'], $item['favs'], $item['downs'], 'sfw');
			return intermix(self::$code, [$item['media_ID'], $item['filename'], getExtension($item['filename']), $stats]);
		}

		static function generatePageList($current_page, $page_count)
		{}

		static function generateStats($ups, $favs, $downs, $sfwrating)
		{
			$rating = '';
			$color = '';
			switch ($sfwrating)
			{
				case 'sfw':
					$rating = 'S';
					$color = 'upvote';
				break;
				case 'qsfw':
					$rating = 'Q';
					$color = 'favorite';
				break;
				case 'nsfw':
					$rating = 'N';
					$color = 'downvote';
				break;
			}
			return intermix(self::$thumbcode, [$ups, $favs, $downs, $color, $rating]);
		}

		static private $thumbcode =
		[
			'<span class="upvote">&#9652; ',

			'</span><span class="favorite"> &#9829; ',

			'</span><span class="downvote"> &#9662; ',

			'</span><span class="',

			'"> ',

			'</span>'
		];

		static private $code =
		[
			'<div class="thumbnailbox">
				<a href="/media/',

				'">
					<img class="thumbnail" src="/storage/',

					'_200.',

					'">
				</a>
				<div class="thumbnailbar">
					<div class="smalltext">',

					'</div>
				</div>
				<div class="vertical space">
				</div>
			</div>
			<div class="horizontal space"></div>'
		];
	}
?>

<?php
	require_once 'utils/StringManip.php';
	class Thumbnail
	{

		static private $pagebuttoncode =
		[
			'<input name="page" type="submit" value="',
			'">'
		];

		static private $pagebuttoncounter =
		[
			'<form action="/" method="get">',
			'</form>'
		];

		static function generatePageButton($number)
		{
			if ($number > 0)
				return intermix(self::$pagebuttoncode, [$number]);
			else
				return '';
		}

		static function generatePageCounter($pages, $current)
		{
			$html = self::generatePageButton(1);
			for ($i = -5; $i <= 5; ++$i)
			{
				$page = $current + $i;
				if ($page > 1 && $page < $pages)
					$html .= self::generatePageButton($page);
			}
			if ($pages != 1)
				$html .= self::generatePageButton($pages);
			return intermix(self::$pagebuttoncounter, [$html]);
		}

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

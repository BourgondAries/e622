<?php
	require_once 'utils/StringManip.php';
	class Thumbnail
	{

		static private $pagebuttoncode =
		[
			'<input id="pagebutton', '" name="page" type="submit" value="',
			'">'
		];

		static private $taginput =
		[
			'<input type="hidden" name="tags" value="',
			'">'
		];

		static private $pagebuttoncounter =
		[
			'<form action="/',
			'" method="get">',
			'</form>', ''
		];

		static function generatePageButton($number)
		{
			if ($number > 0)
				return intermix(self::$pagebuttoncode, [$number, $number]);
			else
				return '';
		}

		static private $navigation_script =
		[
			'<script>
				function navigate(event)
				{
					if (event.keyIdentifier == "Right")
						document.getElementById("pagebutton', '").click();
					if (event.keyIdentifier == "Left")
						document.getElementById("pagebutton', '").click();
				}
			</script>'
		];

		static function generateNavigationScript($pages, $current)
		{
			$current += 1;
			$prev = $current - 1;
			$next = $current + 1;
			if ($next > $pages)
				$next = $pages;
			if ($prev < 1)
				$prev = 1;
			return intermix(self::$navigation_script, [$next, $prev]);
		}

		static function generatePageCounter($pages, $current, $search = '', $tags = '')
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
			if ($tags != '')
				$html .= intermix(self::$taginput, [$tags]);
			$pagescript = self::generateNavigationScript($pages, $current);
			return intermix(self::$pagebuttoncounter, [$search, $html, $pagescript]);
		}

		static function generateThumbnails($list)
		{
			$html = '';
			if ($list != null && !empty($list))
				foreach ($list as &$list_elem)
					$html .= self::generateThumbnail($list_elem);
			else
				$html = '<div class="bigtext"> No results :(</div>';
			return $html;
		}

		static function generateThumbnail($item)
		{
			$stats = self::generateStats($item['ups'], $item['favs'], $item['downs'], $item['safety']);
			$extension = getExtension($item['filename']);
			if ($extension == 'webm')
			{
				$item['filename'] .= '.png';
				$extension = 'png';
			}
			return intermix(self::$code, [$item['media_ID'], $item['filename'], $extension, $stats]);
		}

		static function generatePageList($current_page, $page_count)
		{}

		static function generateStats($ups, $favs, $downs, $sfwrating)
		{
			$rating = '';
			$color = '';
			switch ($sfwrating)
			{
				case 1:
				case 'sfw':
					$rating = 'S';
					$color = 'upvote';
				break;
				case 2:
				case 'qsfw':
					$rating = 'Q';
					$color = 'favorite';
				break;
				case 3:
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
			'
			<div class="thumbnailbox">
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

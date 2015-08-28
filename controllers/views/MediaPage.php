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

		static function renderControls($id, $user_affiliation = null)
		{
			if ($user_affiliation == null)
				return intermix(self::$statistics, [$id, 'upvote', $id, 'favorite', $id, 'downvote']);
			else
			{
				$ui = $user_affiliation;
				$up = $ui['upvote'] == 1 ? '&#8658; ' : '';
				$fav = $ui['favorite'] == 1 ? '&#8658; ' : '';
				$down = $ui['downvote'] == 1 ? '&#8658; ' : '';
				return intermix(self::$statistics, [$id, $up, $id, $fav, $id, $down]);
			}
		}

		static private $statistics =
		[
			'<div class="statistic smalltext table">
				<div class="row">
					<form action="/upvote/',

					'" method="post">
						<input class="upvote" type="submit" value="',

						'&#9652; Upvote">
					</form>
				</div>
				<div class="row">
					<form action="/favorite/',

					'" method="post">
						<input class="favorite" type="submit" value="',

						'&#9829; Favorite">
					</form>
				</div>
				<div class="row">
					<form action="/downvote/',

					'" method="post">
						<input class="downvote" type="submit" value="',

						'&#9662; Downvote">
					</form>
				</div>
			</div>'
		];

		static private $video_code =
		[
			'<video class="media" autoplay controls>
				<source src="/storage/',

				'" type="video/webm">
				<div class="warning">
					Your browser does not appear to support webm video.
				</div>
			</video>'
		];

		static private $code =
		[
			'<img class="media" src="/storage/',

			'">'
		];
	}
?>

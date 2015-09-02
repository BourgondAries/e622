<?php
	require_once 'utils/StringManip.php';
	class MediaPage
	{
		private static function renderTags($id, $taglist)
		{
			$tags = implode($taglist, ' ');
			return intermix(self::$tagcode, [$id, $tags]);
		}

		private static $tagcode =
		[
			'<div class="bigtext">Tags</div>
			<div class="vertical space"></div>
			<form action="/tagchange/', '" method="post">
				<textarea name="tags">', '</textarea>
				<input type="submit" value="submit">
			</form>
			<div class="vertical space"></div>'
		];

		private static function renderDescription($id, $description)
		{
			return intermix(self::$description_code, [$id, $description]);
		}

		private static $description_code =
		[
			'<div class="vertical space"></div>
			<div class="bigtext">Description</div>
			<div class="vertical space"></div>
			<form action="/postdescription/','" method="post">
				<textarea name="description">','</textarea>
				<input type="submit" value="submit">
			</form>
			<div class="vertical space"></div>'
		];

		private static function renderCommentWriter($media_id)
		{
			return intermix(self::$comment_box_code, [$media_id]);
		}

		private static $comment_box_code =
		[
			'<div class="bigtext">Comment</div>
			<div class="vertical space"></div>
			<form action="/postcomment/', '" method="post">
					<textarea placeholder="your comment"></textarea>
					<input type="submit" value="submit">
				</form>',
			''
		];

		static function renderComment($comment_info)
		{
			intermix();
		}

		static private $comment_code =
		[
			'<div class="comment">',

			'</div>'
		];

		static function render($media_data, $associated_tags)
		{
			$code = '';
			if (getExtension($media_data['filename']) == 'webm')
				$code = intermix(self::$video_code, [$media_data['filename']]);
			else
				$code = intermix(self::$code, [$media_data['filename']]);
			$code .= self::renderDescription($media_data['media_ID'], $media_data['description']);
			$code .= self::renderTags($media_data['media_ID'], $associated_tags);
			$code .= self::renderCommentWriter($media_data['media_ID']);
			return $code;
		}

		static function renderControls($id, $user_affiliation, $stats)
		{
			if ($stats['ups'] == null)
				$stats = array('ups' => 0, 'favs' => 0, 'downs' => 0);
			if ($user_affiliation == null)
				return intermix(self::$statistics, [$id, '', $id, '', $id, '', $stats['ups'], $stats['favs'], $stats['downs']]);
			else
			{
				$ui = $user_affiliation;
				$up = $ui['upvote'] == 1 ? '&#8658; ' : '';
				$fav = $ui['favorite'] == 1 ? '&#8658; ' : '';
				$down = $ui['downvote'] == 1 ? '&#8658; ' : '';
				return intermix(self::$statistics, [$id, $up, $id, $fav, $id, $down, $stats['ups'], $stats['favs'], $stats['downs']]);
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
			</div>
			<div class="vertical space"></div>
			<div class="table center">
				<div class="cell upvote"> &#9652; ',

				'</div>
				<div class="cell favorite"> &#9829; ',

				'</div>
				<div class="cell downvote"> &#9662; ',

				'</div>
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

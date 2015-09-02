<?php
	require_once 'db/Database.php';
	class Media
	{
		private $dbc;

		function __construct()
		{
			$this->dbc = new Database;
		}

		function __destruct()
		{
			$this->dbc->get()->commit();
		}

		function getComments($id, $page, $posts_per_page)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('SELECT * FROM Comment JOIN User ON User.user_ID = Comment.user_ID JOIN Privilege ON User.privilege = Privilege.privilege_id WHERE media_ID = ? ORDER BY comm_date DESC LIMIT ?, ?;'))
			{
				$offset = $page * $posts_per_page;
				$prepare->bind_param('iii', $id, $offset, $posts_per_page);
				$prepare->execute();
				$rows = [];
				$result = $prepare->get_result();
				while ($row = $result->fetch_assoc())
					$rows[] = $row;
				return $rows;
			}
		}

		function postComment($id, $userid, $comment)
		{
			$comment = htmlspecialchars($comment);
			$this->postCommentAuthorized($id, $userid, $comment);
		}

		private function postCommentAuthorized($id, $userid, $comment)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('INSERT INTO Comment (user_ID, media_ID, comment) VALUES (?, ?, ?);'))
			{
				$prepare->bind_param('iis', $userid, $id, $comment);
				$prepare->execute();
			}
		}

		function getAllTags($id)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('SELECT * FROM MediaTag JOIN Tag ON Tag.tag_ID = MediaTag.tag_ID WHERE media_ID = ? ORDER BY MediaTag.placing ASC;'))
			{
				$prepare->bind_param('i', $id);
				$prepare->execute();
				$result = $prepare->get_result();
				$taglist = [];
				while ($row = $result->fetch_assoc())
					$taglist[] = $row['description'];
			}
			return $taglist;
		}

		function updateDescription($media_id, $user_id, $description)
		{
			$description = htmlspecialchars($description);
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('UPDATE Media SET description = ? WHERE media_ID = ?;'))
			{
				$prepare->bind_param('si', $description, $media_id);
				$prepare->execute();
			}
			$this->postCommentAuthorized($media_id, $user_id, "<strong>Description Update:</strong><br>" . $description);
		}

		function updateTags($media_id, $userid, $tags)
		{
			$tags = htmlspecialchars($tags);
			$this->postCommentAuthorized($media_id, $userid, "<strong>Tag Update:</strong><br>" . $tags);
			$tags = explode(' ', $tags);
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('DELETE FROM MediaTag WHERE media_ID = ?;'))
			{
				$prepare->bind_param('i', $media_id);
				$prepare->execute();
			}
			else
			{
				echo $db->error;
				die();
			}
			$tags = array_unique($tags);
			if (!in_array('sfw', $tags) && !in_array('qsfw', $tags) && !in_array('nsfw', $tags))
				$tags[] = 'nsfw';
			$counter = 0;
			foreach ($tags as &$tag)
			{
				if ($tag == '--')
					break;
				++$counter;
			}
			$unsorted_tags = array_slice($tags, 0, $counter);
			$sorted_tags = array_slice($tags, $counter);
			sort($sorted_tags, SORT_STRING);

			$tag_ids = [];
			foreach ($unsorted_tags as &$tag)
				$tag_ids[] = $this->insertTag($tag);
			foreach ($sorted_tags as &$tag)
				$tag_ids[] = $this->insertTag($tag);
			$counter = 0;
			foreach ($tag_ids as &$tag_id)
			{
				$this->associateTag($media_id, $tag_id, $counter);
				++$counter;
			}
		}

		private function insertTag($tagname)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('INSERT IGNORE INTO Tag (description) VALUES (?); '))
			{
				$prepare->bind_param('s', $tagname);
				$prepare->execute();
				if ($prepare = $db->prepare('SELECT tag_ID FROM Tag WHERE description = ?;'))
				{
					$prepare->bind_param('s', $tagname);
					$prepare->execute();
					$result = $prepare->get_result();
					if ($row = $result->fetch_array())
						return $row[0];
				}
			}
			else
			{
				return $db->error;
			}
		}

		private function associateTag($media_id, $tag_id, $placing)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('INSERT INTO MediaTag (tag_ID, media_ID, placing) VALUES (?, ?, ?);'))
			{
				$prepare->bind_param('iii', $tag_id, $media_id, $placing);
				$prepare->execute();
			}
			else
				echo $db->error;
		}

		function getMediaStatistics($id)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('SELECT sum(upvote) AS ups, sum(favorite) AS favs, sum(downvote) AS downs FROM UserFeedback WHERE media_ID = ?;'))
			{
				$prepare->bind_param('i', $id);
				$prepare->execute();
				$result = $prepare->get_result();
				return $result->fetch_assoc();
			}
		}

		function getTagId($description)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('SELECT tag_ID FROM Tag WHERE description = ?;'))
			{
				$prepare->bind_param('s', $description);
				$prepare->execute();
				$result = $prepare->get_result();
				if ($row = $result->fetch_array())
					return $row[0];
				else
					return null;
			}
		}

		function getMedia($id)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('SELECT * FROM Media WHERE media_ID = ?;'))
			{
				$prepare->bind_param('i', $id);
				$prepare->execute();
				$result = $prepare->get_result();
				return $result->fetch_assoc();
			}
		}

		function getUserVotes($media_id, $user_id)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('SELECT * FROM UserFeedback WHERE media_ID = ? AND user_ID = ?;'))
			{
				$prepare->bind_param('ii', $media_id, $user_id);
				$prepare->execute();
				$result = $prepare->get_result();
				return $result->fetch_assoc();
			}
		}

		function upvote($media_id, $user_id)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('INSERT INTO UserFeedback (user_ID, media_ID, upvote) VALUES (?, ?, true) ON DUPLICATE KEY UPDATE upvote = !upvote;'))
			{
				$prepare->bind_param('ii', $user_id, $media_id);
				$prepare->execute();
			}
			else
			{
				echo $db->error;
				die();
			}
		}

		function favorite($media_id, $user_id) {
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('INSERT INTO UserFeedback (user_ID, media_ID, favorite) VALUES (?, ?, true) ON DUPLICATE KEY UPDATE favorite = !favorite;'))
			{
				$prepare->bind_param('ii', $user_id, $media_id);
				$prepare->execute();
			}
			else
			{
				echo $db->error;
				die();
			}
		}

		function downvote($media_id, $user_id)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('INSERT INTO UserFeedback (user_ID, media_ID, downvote) VALUES (?, ?, false) ON DUPLICATE KEY UPDATE downvote = !downvote;'))
			{
				$prepare->bind_param('ii', $user_id, $media_id);
				$prepare->execute();
			}
			else
			{
				echo $db->error;
				die();
			}
		}

		function getPage($tags, $pagenumber, $items_per_page)
		{
			$db = $this->dbc->get();
			if (empty($tags))
			{
				if ($prepare = $db->prepare
					('
						SELECT Media.media_ID, filename, sum(upvote) AS ups, sum(favorite) AS favs, sum(downvote) AS downs
						FROM Media
						LEFT JOIN UserFeedback ON Media.media_ID = UserFeedback.media_ID
						GROUP BY UserFeedback.media_ID
						ORDER BY upload_date DESC
						LIMIT ?, ?;
					'))
				// if ($prepare = $db->prepare('SELECT * FROM Media ORDER BY upload_date DESC LIMIT ?, ?;'))
				{
					$start_at = $pagenumber * $items_per_page;
					$prepare->bind_param('ii', $start_at, $items_per_page);
					$prepare->execute();
					$result = $prepare->get_result();
					$media = array();
					while ($row = $result->fetch_assoc())
						$media[] = $row;
					if ($prepare = $db->prepare('SELECT count(media_ID) AS elems FROM Media;'))
					{
						$prepare->execute();
						$result = $prepare->get_result();
						$result = $result->fetch_assoc();
						$pagecount = intval(ceil($result['elems'] / $items_per_page));
						return ['media' => $media, 'pagecount' => $pagecount];
					}
				}
			}
			$tag_ids = [];
			foreach ($tags as &$tag)
			{
				$result = $this->getTagId($tag);
				if ($result)
					$tag_ids[] = $result;
			}
			$tag_string = implode(',', $tag_ids);

			$media = [];
			if ($prepare = $db->prepare
				('
					SELECT * FROM MediaTag
					JOIN Media ON Media.media_ID = MediaTag.media_ID
					WHERE tag_ID in (?)
					GROUP BY MediaTag.media_ID
					HAVING count(distinct tag_ID) > ?
					ORDER BY upload_date DESC
					LIMIT ?, ?;
				'))
			{
				$amount = count($tag_ids) - 1;
				$start_at = $pagenumber * $items_per_page;
				$prepare->bind_param('siii', $tag_string, $amount, $start_at, $items_per_page);
				$prepare->execute();
				$result = $prepare->get_result();
				while ($row = $result->fetch_assoc())
				{
					if ($prepare = $db->prepare
						('
							SELECT sum(upvote) AS ups, sum(favorite) AS favs, sum(downvote) AS downs
							FROM UserFeedback
							WHERE media_ID = ?
							GROUP BY media_ID;
						'))
					{
						$prepare->bind_param('i', $row['media_ID']);
						$prepare->execute();
						$status_result = $prepare->get_result();
						$status_row = $status_result->fetch_assoc();
						$row['ups'] = $status_row['ups'];
						$row['favs'] = $status_row['favs'];
						$row['downs'] = $status_row['downs'];
					}
					else
						echo $db->error;
					$media[] = $row;
				}

				$returnvar = array('media' => $media);

				if ($prepare = $db->prepare
				(
					'SELECT count(media_ID) FROM MediaTag
					WHERE tag_ID in (?)
					GROUP BY media_ID
					HAVING count(distinct tag_ID) > ?;'
				))
				{
					$prepare->bind_param('si', $tag_string, $amount);
					$prepare->execute();
					$result = $prepare->get_result();
					$returnvar['pagecount'] = intval(ceil($result->num_rows / $items_per_page));
				}
				return $returnvar;
			}
			else
				echo $db->error;
		}
	}
?>

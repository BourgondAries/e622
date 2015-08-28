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

		function favorite($media_id, $user_id)
		{
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
				if ($prepare = $db->prepare('SELECT * FROM Media ORDER BY upload_date DESC LIMIT ?, ?;'))
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
				$media = array();
				while ($row = $result->fetch_assoc())
					$media[] = $row;

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

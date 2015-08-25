<?php
	require_once 'db/Database.php';
	class Media
	{
		private $dbc;

		function __construct()
		{
			$this->dbc = new Database;
		}

		private function getTagId($description)
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

		function getPage($tags, $pagenumber, $pagecount)
		{
			$tag_ids = [];
			foreach ($tags as &$tag)
			{
				$result = $this->getTagId($tag);
				if ($result)
					$tag_ids[] = $result;
			}
			$tag_string = implode(',', $tag_ids);

			$db = $this->dbc->get();
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
				$start_at = $pagenumber * $pagecount;
				$prepare->bind_param('siii', $tag_string, $amount, $start_at, $pagecount);
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
					if ($row = $result->fetch_array())
						$returnvar['pagecount'] = intval(ceil($row[0] / $pagecount));
					else
						$returnvar['pagecount'] = 0;
				}
				return $returnvar;
			}
			else
				echo $db->error;
		}
	}
?>

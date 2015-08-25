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
					SELECT media_ID FROM MediaTag
					WHERE tag_ID in (?)
					GROUP BY media_ID
					HAVING count(distinct tag_ID) > ?
					LIMIT ?, ?;
				'))
			{
				$amount = count($tag_ids) - 1;
				$start_at = $pagenumber * $pagecount;
				$prepare->bind_param('siii', $tag_string, $amount, $start_at, $pagecount);
				$prepare->execute();
				$result = $prepare->get_result();
				while ($row = $result->fetch_array())
				{
					echo 'value: ';
					echo $row[0];
					echo '<br>';
				}
			}
			else
				echo $db->error;
			die();
		}
	}
?>

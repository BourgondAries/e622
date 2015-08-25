<?php
	require_once 'db/Database.php';
	class Upload
	{
		private $dbc;

		function __construct()
		{
			$this->dbc = new Database();
		}

		function __destruct()
		{
			$this->dbc->get()->commit();
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

		function uploadFile($uploader, $description, $tags, $file)
		{
			// Check if the uploader has enough privileges
			if ($uploader['privilege'] > 3)
				return 'no_privilege';

			$tags = explode(' ', $tags);
			if (count($tags) == 0)
				return 'no_tags';

			$tags = array_unique($tags);
			$counter = 0;
			foreach ($tags as &$tag)
			{
				if ($tag == '--')
					break;
				++$counter;
			}
			$unsorted_tags = array_slice($tags, 0, $counter);
			$sorted_tags = array_slice($tags, $counter + 1);
			var_dump($unsorted_tags);
			sort($sorted_tags, SORT_STRING);
			var_dump($sorted_tags);

			$tag_ids = [];
			foreach ($unsorted_tags as &$tag)
				$tag_ids[] = $this->insertTag($tag);
			foreach ($sorted_tags as &$tag)
				$tag_ids[] = $this->insertTag($tag);
		}
	}
?>

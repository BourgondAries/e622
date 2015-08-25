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

		private function insertMedia($uploaderid, $description, $file, $extension)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('INSERT INTO Media (description,  uploader) VALUES (?, ?);'))
			{
				$prepare->bind_param('si', $description, $uploaderid);
				$prepare->execute();
				$mediaid = $db->insert_id;
				if ($prepare = $db->prepare('UPDATE Media SET filename = ? WHERE media_ID = ?;'))
				{
					$newname = base_convert($mediaid, 10, 36) . ".$extension";
					$prepare->bind_param('si', $newname, $mediaid);
					$prepare->execute();
					$root = $_SERVER['DOCUMENT_ROOT'];
					rename($file, "$root/storage/" . $newname);
				}
			}
		}

		static function startsWith($string, $query)
		{
			return substr($string, 0, strlen($query)) === $query;
		}

		function getFileType($file)
		{
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$type = finfo_file($finfo, $file);
			finfo_close($finfo);
			if (!self::startsWith($type, 'image') && !self::startsWith($type, 'video'))
				return false;
			switch ($type)
			{
				case 'image/gif': return 'gif';
				case 'image/png': return 'png';
				case 'image/jpg': return 'jpg';
				case 'image/jpeg': return 'jpeg';
				case 'video/webm': return 'webm';
				default: return false;
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
			sort($sorted_tags, SORT_STRING);

			$tag_ids = [];
			foreach ($unsorted_tags as &$tag)
				$tag_ids[] = $this->insertTag($tag);
			foreach ($sorted_tags as &$tag)
				$tag_ids[] = $this->insertTag($tag);
			var_dump($tag_ids);
			$extension = $this->getFileType($file);
			if ($extension == false)
				return false;
			$this->insertMedia($uploader['user_ID'], $description, $file, $extension);
		}
	}
?>

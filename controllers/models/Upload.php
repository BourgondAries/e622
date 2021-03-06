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

		static function getMediaType($filename)
		{
			return preg_replace('/[a-z0-9]+\.([a-z]+)/', '$1', $filename);
		}

		static function generateVidThumbnail($src, $thumb_width)
		{
			system("avconv -i $src 2>&1 | grep Duration | cut -d ' ' -f 4 | sed s/,// > $src.duration");
			$duration = file_get_contents("$src.duration");
			$times = split(':', $duration);
			$time = (floatval($times[2]) +
				floatval($times[1]) * 60 +
				floatval($times[0]) * 3600) / 2;
			system("avconv -ss $time -i $src -vframes 1 -q:v 2 $src.png");
			self::generateThumbnail("$src.png", 'png', 200);
		}

		static function generateThumbnail($src, $type, $thumb_width)
		{
			$dest = "${src}_${thumb_width}.$type";
			$source_image = '';
			switch ($type)
			{
				case 'png': $source_image = imagecreatefrompng($src); break;
				case 'gif': $source_image = imagecreatefromgif($src); break;
				case 'jpeg': $source_image = imagecreatefromjpeg($src); break;
				case 'jpg': $source_image = imagecreatefromjpeg($src); break;
				default: return;
			}
			$width = imagesx($source_image);
			$height = imagesy($source_image);
			$desired_height = floor($height * ($thumb_width / $width));
			$virtual_image = imagecreatetruecolor($thumb_width , $desired_height);
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $thumb_width, $desired_height, $width, $height);
			switch ($type)
			{
				case 'png': imagepng($virtual_image, $dest); break;
				case 'gif': imagegif($virtual_image, $dest); break;
				case 'jpeg': imagejpeg($virtual_image, $dest); break;
				case 'jpg': imagejpeg($virtual_image, $dest); break;
				default: return;
			}
		}

		function existsId($id)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('SELECT 1 FROM Media WHERE media_ID = ?;'))
			{
				$prepare->bind_param('i', $id);
				$prepare->execute();
				return 0 < $prepare->get_result()->num_rows;
			}
		}

		function rollback()
		{
			return $this->dbc->get()->rollback();
		}

		function linkFromTo($from, $to, $uid)
		{
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('SELECT * FROM MediaLink WHERE from_id = ?;'))
			{
				$prepare->bind_param('i', $from);
				$prepare->execute();
				$result = $prepare->get_result()->fetch_assoc();
				if ($result != null)
					if ($prepare = $db->prepare('SELECT * FROM Media WHERE media_ID = ?;'))
					{
						$prepare->bind_param('i', $from);
						$prepare->execute();
						$result = $prepare->get_result()->fetch_assoc();
						if ($result['uploader'] == $uid)
						{
							$db = $this->dbc->get();
							if ($prepare = $db->prepare('UPDATE MediaLink SET to_id = ? WHERE from_id = ?;'))
							{
								$prepare->bind_param('ii', $to, $from);
								$prepare->execute();
								return $db->affected_rows;
							}
						}
						else
							return 0;
					}
			}
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('INSERT INTO MediaLink (from_id, to_id) VALUES (?, ?);'))
			{
				$prepare->bind_param('ii', $from, $to);
				$prepare->execute();
				return $db->affected_rows;
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

		private function insertMedia($uploaderid, $description, $file, $extension, $tags)
		{
			$description = htmlspecialchars($description);
			$db = $this->dbc->get();
			if ($prepare = $db->prepare('INSERT INTO Media (description,  uploader) VALUES (?, ?);'))
			{
				$prepare->bind_param('si', $description, $uploaderid);
				$prepare->execute();
				$mediaid = $db->insert_id;
				if ($prepare = $db->prepare('INSERT INTO UserFeedback (media_ID, user_ID) VALUES (?, 1);'))
				{
					$prepare->bind_param('i', $mediaid);
					$prepare->execute();
					if ($prepare = $db->prepare('INSERT INTO Comment (user_ID, media_ID, comment) VALUES (?, ?, ?);'))
					{
						$string = "<strong>Uploaded:</strong><br>Description: $description<br>Tags: $tags";
						$prepare->bind_param('iis', $uploaderid, $mediaid, $string);
						$prepare->execute();

					}
					if ($prepare = $db->prepare('UPDATE Media SET filename = ? WHERE media_ID = ?;'))
					{
						$newname = base_convert($mediaid, 10, 36) . ".$extension";
						$prepare->bind_param('si', $newname, $mediaid);
						$prepare->execute();
						$root = $_SERVER['DOCUMENT_ROOT'];
						rename($file, "$root/storage/$newname");
						if ($extension == 'webm')
							self::generateVidThumbnail("$root/storage/$newname", 200);
						else
							self::generateThumbnail("$root/storage/$newname", $extension, 200);
						return $mediaid;
					}
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
				return "wrong_mime";
			switch ($type)
			{
				case 'image/gif': return 'gif';
				case 'image/png': return 'png';
				case 'image/jpg': return 'jpg';
				case 'image/jpeg': return 'jpeg';
				case 'video/webm': return 'webm';
				default: return "wrong_submime";
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
		}

		function uploadFile($uploader, $description, $tags, $file)
		{
			$tags = htmlspecialchars($tags);
			// Check if the uploader has enough privileges
			if ($uploader['privilege'] > 4 /* user */)
				return 'wrong_no_privilege';

			$tags = trim($tags);
			if (empty($tags))
				return 'wrong_no_tags';
			$tags = explode(' ', $tags);
			if (count($tags) == 0)
				return 'wrong_no_tags';

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
			$extension = $this->getFileType($file);
			if (self::startsWith($extension, 'wrong'))
				return $extension;
			$media_id = $this->insertMedia($uploader['user_ID'], $description, $file, $extension, implode(' ', $tags));
			$counter = 0;
			foreach ($tag_ids as &$tag_id)
			{
				$this->associateTag($media_id, $tag_id, $counter);
				++$counter;
			}
			return $media_id;
		}
	}
?>

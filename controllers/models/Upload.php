<?php
	require_once 'db/Database.php';
	class Upload
	{
		static function uploadFile($uploader, $description, $tags, $file)
		{
			// Check if the uploader has enough privileges
			if ($uploader['privilege'] > 3)
				return 'no_privilege';

			echo $file;

		}
	}
?>

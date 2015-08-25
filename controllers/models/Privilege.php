<?php
	require_once 'db/Database.php';
	class Privilege
	{
		static function getPrivileges()
		{
			$dbc = new Database;
			$db = $dbc->get();

			if ($prepare = $db->prepare('SELECT * FROM Privilege ORDER BY privilege_id'))
			{
				$prepare->execute();
				$result = $prepare->get_result();
				$array = array();
				while ($row = $result->fetch_assoc())
					array_push($array, $row);
				return $array;
			}
			else
				return $db->error;
		}
	}
?>

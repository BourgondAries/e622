<?php
	class Http
	{
		static function has($name)
		{
			return (isset($_GET[$name]) || isset($_POST[$name]));
		}

		static function get($name)
		{
			if (isset($_GET[$name]))
				return $_GET[$name];
			else if (isset($_POST[$name]))
				return $_POST[$name];
		}
	}
?>

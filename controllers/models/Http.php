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

		static function getOrZero($name)
		{
			if (self::has($name))
				return self::get($name);
			return 0;
		}

		static function getOrOne($name)
		{

			if (self::has($name))
				return self::get($name);
			return 1;
		}

		static function getFile($name)
		{
			return $_FILES[$name];
		}
	}
?>

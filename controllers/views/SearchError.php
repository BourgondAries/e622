<?php
	include_once 'utils/StringManip.php';
	class SearchError
	{
		static private $error_template =
		['<div class="warning"> The tag',

			' not present in the database and ',' been excluded from the search.</div>'
		];

		static private function oxfordify($list)
		{
			$size = count($list);
			if ($size == 1)
				return ' ' . $list[0] . ' is';
			if ($size == 2)
				return 's ' . $list[0] . ' and ' . $list[1] . ' are';
			$code = 's ';
			for ($i = 0; $i <= $size - 2; ++$i)
				$code .= $list[$i] . ', ';
			return $code . ' and ' . $list[$size - 1] . ' are';
		}

		static function maybeWriteError($unused)
		{
			if (empty($unused))
				return '';
			$have = 'has';
			if (count($unused) >= 2)
				$have = 'have';
			$unused = self::oxfordify($unused);
			return intermix(self::$error_template, [$unused, $have]);
		}
	}
?>

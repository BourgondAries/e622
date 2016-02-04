<?php
	include_once 'utils/StringManip.php';
	class SearchError
	{
		static private $error_template =
		['<div class="warning"> The tags ',

			' are not present in the database and have been excluded from the search.</div>'
		];

		static private function oxfordify($list)
		{
			$size = count($list);
			if ($size == 1)
				return $list[0];
			if ($size == 2)
				return $list[0] . ' and ' . $list[1];
			$code = '';
			for ($i = 0; $i <= $size - 2; ++$i)
				$code .= $list[$i] . ', ';
			return $code . ' and ' . $list[$size - 1];
		}

		static function maybeWriteError($unused)
		{
			if (empty($unused))
				return '';
			$unused = self::oxfordify($unused);
			return intermix(self::$error_template, [$unused]);
		}
	}
?>

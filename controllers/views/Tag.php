<?php
	require_once 'utils/StringManip.php';
	class Tag
	{
		private static $template =
		[
			'', ' (', ')'
		];

		private static $table =
		[ '<div class="autotable">
				<div class="small table-column"></div>
				<div class="tiny table-column"></div>
				<div class="big table-column"></div>',
			'</div>'
		];

		private static $row =
		[ '<div class="row">', '</div>' ];

		private static $cell =
		[ '<div class="cell">', '</div>' ];

		private static $vertspace =
			'<div class="row"><div class="vertical space"></div></div>';

		static function every($value, $cmp)
		{ return $value % $cmp == $cmp - 1; }

		static function render($tags)
		{
			$total = '';
			$html = '';
			$d = 'description';
			$n = 'number';
			for ($i = 0; $i < count($tags); ++$i)
			{
				$html .= intermix(self::$template, [$tags[$i][$d], $tags[$i][$n]]);
				$html .= ', ';
				if (self::every($i, 5))
					$html .= '<br>';
				if (self::every($i, 10) || $i == count($tags) - 1)
				{
					$left = intermix(self::$cell, ['Top ' . ($i + 1)]);
					$right = intermix(self::$cell, [$html]);
					$middle = intermix(self::$cell, ['']);
					$total .= intermix(self::$row, [$left . $middle . $right]);
					$total .= self::$vertspace;
					$html = '';
				}
			}
			return intermix(self::$table, [$total]);
		}
	}
?>

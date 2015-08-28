<?php
	function intermix($template, $array)
	{
		$result = '';
		for ($i = 0; $i < count($template); ++$i)
		{
			$result .= $template[$i];
			if ($i < count($array))
				$result .= $array[$i];
		}
		return $result;
	}
?>

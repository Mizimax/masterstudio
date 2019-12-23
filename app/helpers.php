<?php

	if (!function_exists('toDayText')) {
		/**
		 * Returns name of day from date routine
		 *
		 * @param integer/string $number
		 *
		 * @return string a string of day.
		 *
		 * */
		function toDayText($number)
		{
			$days = [0 => 'Everyday', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun'];
			return $days[(int)$number];
		}
	}

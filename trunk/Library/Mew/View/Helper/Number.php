<?php

/*
 */

PhpMew2::load('Mew/View/Helper');

class Mew_View_Helper_Number extends Mew_View_Helper
{
	function format( $number, $precision = 0 )
	{
		return number_format( $number, $precision );
	}
}


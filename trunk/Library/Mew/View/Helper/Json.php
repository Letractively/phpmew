<?php

/*
 */
class Mew_View_Helper_Json
{
	function escape( $input )
	{
	        return str_replace(Array("\r", "\n"), Array('', '\\\\n'), $input);
	}
}


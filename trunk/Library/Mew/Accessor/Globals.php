<?php

/*
 */
class Mew_Accessor_Globals
{
	public function __call( $method, $argument = null )
	{
		$key = strtoupper( $method );

		if ( isset( $_GLOBALS[ $key ] ) )
		{
			return $_GLOBALS[ $key ];
		}

		return null;
	}
}

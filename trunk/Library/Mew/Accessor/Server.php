<?php

/*
 */
class Mew_Accessor_Server
{
	public function __call( $method, $argument = Array() )
	{
		$key = strtoupper( $method );

		if ( isset( $_SERVER[ $key ] ) )
		{
			return $_SERVER[ $key ];
		}

		return null;
	}
}

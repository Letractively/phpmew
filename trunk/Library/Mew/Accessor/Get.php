<?php

/*
 */
class Mew_Accessor_Get
{
	public function __call( $method, $argument = null )
	{
		if ( isset( $_GET[ $method ] ) )
		{
			return trim( $_GET[ $method ] );
		}

		return null;
	}
}

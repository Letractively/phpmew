<?php

/*
 */
class Mew_Accessor_Request
{
	public function __call( $method, $argument = null )
	{
		if ( isset( $_REQUEST[ $method ] ) )
		{
			return trim( $_REQUEST[ $method ] );
		}

		return null;
	}
}

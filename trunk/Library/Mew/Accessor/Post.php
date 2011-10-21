<?php

/*
 */
class Mew_Accessor_Post
{
	public function __call( $method, $argument = null )
	{
		if ( isset( $_POST[ $method ] ) )
		{
			return trim( $_POST[ $method ] );
		}

		return null;
	}
}

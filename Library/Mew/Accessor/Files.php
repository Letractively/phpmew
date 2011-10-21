<?php

/*
 */
class Mew_Accessor_Files
{
	public function __call( $method, $argument = null )
	{
		if ( isset( $_FILES[ $method ] ) )
		{
			if ( is_uploaded_file( $_FILES[ $method ][ 'tmp_name' ] ) )
			{
				return $_FILES[ $method ];
			}
		}

		return null;
	}
}

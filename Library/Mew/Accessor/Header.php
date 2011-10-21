<?php

/*
	Available headers are:
		HTTP_ACCEPT, HTTP_ACCEPT_CHARSET, HTTP_ACCEPT_ENCODING,
		HTTP_ACCEPT_LANGUAGE, HTTP_CONNECTION, HTTP_HOST,
		HTTP_REFERER, HTTP_USER_AGENT
 */

class Mew_Accessor_Header
{
	public function __call( $method, $argument = null )
	{
		$method = 'HTTP_' . strtoupper( $method );

		if ( isset( $_SERVER[ $method ] ) )
		{
			return $_SERVER[ $method ];
		}

		return null;
	}
}

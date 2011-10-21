<?php

/*
 */

class Mew_Request_Method
{
	public static function is()
	{
		return $_SERVER[ 'REQUEST_METHOD' ];
	}

	public static function isHead()
	{
		return self::isIt( 'HEAD' );
	}

	public static function isGet()
	{
		return self::isIt( 'GET' );
	}

	public static function isPost()
	{
		return self::isIt( 'POST' );
	}

	public static function isPut()
	{
		return self::isIt( 'PUT' );
	}

	public static function isIt( $method )
	{
		return ( self::is() == $method ? true : false );
	}
}


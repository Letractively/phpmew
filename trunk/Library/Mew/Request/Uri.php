<?php

/*
 */
class Mew_Request_Uri
{
	protected static $pathSeparator = '/';
	protected static $baseUrl = null;
	protected static $request = null;

	public static function setBaseUrl( $value )
	{
		self::$baseUrl = $value;
	}

	public static function getRequest()
	{
		if ( self::$request === null )
		{
			self::$request = substr( $_SERVER['REQUEST_URI'], strlen( dirname( $_SERVER['SCRIPT_NAME'] ) ) );
		}

		return self::$request;
	}

	public static function getBaseUrl()
	{
		if ( self::$baseUrl === null )
		{
			$base = substr( $_SERVER[ 'REQUEST_URI' ], 0, strrpos( $_SERVER[ 'REQUEST_URI' ], self::getRequest() ) );
			self::$baseUrl = ( $base == self::$pathSeparator ? null : $base ) . self::$pathSeparator;
		}

		return self::$baseUrl;
	}

	public static function getHostAddress()
	{
		$port   = $_SERVER[ 'SERVER_PORT' ];
		$scheme = ( $port == 80 ? 'http' : ( $port == 443 ? 'https' : $port ) ) . '://';
		$host   = $_SERVER[ 'SERVER_NAME' ];
		$port   = ( $port == 80 || $host == 443 ) ? null : ':' . $port;
		return ( $scheme . $host . $port );
	}

	public static function getBaseUrlFull()
	{
		return ( self::getHostAddress() . self::getBaseUrl() );
	}

	public static function getRequestUriFull()
	{
		return ( self::getHostAddress() . $_SERVER[ 'REQUEST_URI' ] );
	}
}


<?php

/*
 */
// we don't want magic quotes!
ini_set( 'magic_quotes_gpc', 0 );
ini_set( 'magic_quotes_runtime', 0 );

class Mew_Database
{
	protected static $DEFAULT  = 'default';
	protected static $adapters = Array();

	public static function setDefaultAdapter( $adapter )
	{
		self::addAdapter( self::$DEFAULT, $adapter );
	}

	public static function addAdapter( $key, $adapter )
	{
		self::$adapters[ $key ] = $adapter;
	}

	public static function getDefaultAdapter()
	{
		return self::getAdapter( self::$DEFAULT );
	}

	public static function getAdapter( $key )
	{
		if ( array_key_exists( $key, self::$adapters ) )
		{
			return self::$adapters[ $key ];
		}

		return null;
	}

	public static function factory( $adapterClass, $config = Array() )
	{
		return PhpMew2::get( $adapterClass, null, $config );
	}
}

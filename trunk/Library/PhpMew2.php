<?php

/*
 */
// backward compatibility is evil!
ini_set('zend.ze1_compatibility_mode', 0);

//PhpMew2 requires 5 or later
if ( version_compare(PHP_VERSION, '5') === -1 )
{
	die('PhpMew2 requires PHP 5 or later'); //do we really need this?
}

class PhpMew2
{
	protected static $DELIMITER  = '/';
	protected static $UNDERSCORE = '_';
	public    static $EXTENSION  = '.php';
	protected static $PATH       = Array();

	private function __construct()
	{
		//shouldn't make an instance of this class
	}

	public static final function addPath( $key, $path )
	{
		if ( $path[ strlen($path) - 1 ] != self::$DELIMITER )
		{
			$path .= self::$DELIMITER;
		}

		self::$PATH[ $key ] = $path;
	}

	public static final function getPath( $key )
	{
		if ( !array_key_exists( $key, self::$PATH ) )
		{
			return null;
		}

		return self::$PATH[ $key ];
	}

	public static final function toClass( $name )
	{
		return str_replace( self::$DELIMITER, self::$UNDERSCORE, $name );
	}

	public static final function load( $name, $pathKey = null, $exceptionOnError = false )
	{
		if ( $pathKey == null )
		{
			foreach ( self::$PATH as $path )
			{
				$file = $path . $name . self::$EXTENSION;

				if ( file_exists($file) )
				{
					include_once $file;
					return true;
				}
			}

			if ( $exceptionOnError )
			{
				throw new Exception('FILE NOT FOUND');
			}

			return false;
		}

		$file = self::$PATH[ $pathKey ] . $name . self::$EXTENSION;

		if ( file_exists( $file ) )
		{
			include_once $file;
			return true;
		}
		else if ( $exceptionOnError )
		{
			throw new Exception('FILE NOT FOUND');
		}

		return false;
	}

	public static final function get( $name, $pathKey = null, $arguments = null, $exceptionOnError = true )
	{
		$class = self::toClass($name);

		if ( !class_exists($class) )
		{
			if ( !self::load( $name, $pathKey ) )
			{
				if ( $exceptionOnError )
				{
					throw new Exception('FILE NOT FOUND');
				}

				return false;
			}

			if ( !class_exists($class) )
			{
				if ( $exceptionOnError )
				{
					throw new Exception('CLASS NOT FOUND');
				}

				return false;
			}
		}

		return new $class($arguments);
	}
}

?>

<?php

/*
 */
class Mew_View_Helper_Date
{
	static $format       = 'Y-n-d';
	const  seconds_a_day = 86400;

	function format( $input, $format = '%F' )
	{
		return strftime( $format, strtotime( $input ) );
	}

	function yesterday()
	{
		//return strftime( self::$format, strtotime('-1 day') );
		$time = time() - self::seconds_a_day;
		return date( self::$format, $time );
	}

	function today()
	{
		//return strftime( self::$format );
		return date( self::$format, time() );
	}

	function tomorrow()
	{
		//return strftime( self::$format, strtotime('+1 day') );
		$time = time() + self::seconds_a_day;
		return date( self::$format, $time );
	}

	function day( $day = 0 )
	{
		//return strftime( self::$format, strtotime($day . ' day') );
		$time = time() + ( self::seconds_a_day * $day );
		return date( self::$format, $time );
	}
}


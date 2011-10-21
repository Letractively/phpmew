<?php

/*
 */
class Mew_Dispatcher
{
	public static function dispatch( $route, $process = 'Mew/Process/Mvc' )
	{
		if ( is_string( $process ) )
		{
			$process = PhpMew2::get( $process );
		}

		if ( $process->create( $route ) )
		{
			ob_start();
			$process->run();
			ob_end_flush();
		}
	}
}

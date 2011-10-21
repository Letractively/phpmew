<?php

/*
 */

class Mew_View_Cache_Default_Loader
{
	protected $config;

	function __construct( $config )
	{
		if ( !isset( $config['path'] ) )
		{
			throw new Exception( 'PATH IS NOT SET' );
			return;
		}

		if ( !isset( $config['lifetime'] ) )
		{
			$config['lifetime'] = 0;
		}

		$this->config = $config;
	}

	function run( $input = null )
	{
		if ( !file_exists( $this->config['path'] ) )
		{
			return;
		}

		$diff = time() - filemtime( $this->config['path'] );

		if ( $this->config['lifetime'] && $diff >= $this->config['lifetime'] )
		{
			return;
		}

		if ( !is_readable( $this->config['path'] ) )
		{
			return;
		}

		echo file_get_contents( $this->config['path'] );
		throw new Exception( 'CACHE LOADED' );
	}
}


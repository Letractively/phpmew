<?php

/*
 */

class Mew_View_Cache_Default_Recorder
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
		//cache
		if ( file_exists( $this->config['path'] ) )
		{
			$diff = time() - filemtime( $this->config['path'] );

			if ( $this->config['lifetime'] && $diff < $this->config['lifetime'] )
			{
				//not yet expired
				return;
			}
		}

		$dir = dirname( $this->config['path'] );

		if ( !file_exists( $dir ) || !is_dir( $dir ) )
		{
			throw new Exception( 'DIRECTORY NOT FOUND OR NOT A DIRECTORY' );
			return;
		}
		else if ( !is_writable( $dir ) )
		{
			throw new Exception( 'DIRECTORY IS NOT WRITABLE' );
			return;
		}

		if ( file_exists( $this->config['path'] ) && !is_writable( $this->config['path'] ) )
		{
			throw new Exception( 'FILE IS NOT WRITABLE' );
			return;
		}

		file_put_contents( $this->config['path'], $input );
		return $input;
	}
}


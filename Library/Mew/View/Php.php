<?php

/*
 */
class Mew_View_Php
{
	static public  $EXTENSION = '.phtml';
	static private $CONTENT   = null;
	public $title = null;

	function set( $key, $value = null )
	{
		$this->$key = $value;
	}

	function setDefaultExtension( $value )
	{
		self::$EXTENSION = $value;
	}

	function getDefaultExtension()
	{
		return self::$EXTENSION;
	}

	function content()
	{
		return self::$CONTENT;
	}

	function render( $template, $layout = null )
	{
		if ( !file_exists( $template ) )
		{
			$template .= self::$EXTENSION;

			if ( !file_exists( $template ) )
			{
				throw new Exception( 'TEMPLATE NOT FOUND' );
			}
		}

		ob_start();
		include $template;
		$PAGE = ob_get_contents();
		ob_end_clean();

		if ( $layout === null )
		{
			return $PAGE;
		}

		if ( !file_exists( $layout ) )
		{
			$layout .= self::$EXTENSION;

			if ( !file_exists( $layout ) )
			{
				throw new Exception( 'LAYOUT NOT FOUND' );
			}
		}

		self::$CONTENT = $PAGE;
		ob_start();
		include_once $layout;
		$PAGE = ob_get_contents();
		ob_end_clean();
		return $PAGE;
	}
}

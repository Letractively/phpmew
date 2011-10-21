<?php

/*
	example AppController
 */

function json_escape( $input )
{
	return str_replace( Array( "\n", "\r" ), Array( '\\\\n', '' ), $input );
}

class AppController extends Mew_Controller
{
	protected $scripts = Array(
		'js/lib/mlibrary.js',
		'js/script.js'
	);

	function init( &$process )
	{
		$process->setView( PhpMew2::get( 'Mew/View/Php' ) );
		$baseUrl  = Mew_Request_Uri::getBaseUrlFull();
		$path     = PhpMew2::getPath( 'view' );
		$View     = $process->getView();
		$template = $path . $process->getDefaultTemplate();
		$accessor = PhpMew2::get( 'Mew/Accessor/Header' );

		if ( $accessor->Accept() == 'text/json' )
		{
			//AJAX call; use JSON
			$this->ajax = true;
			$layout     = null;
			$template  .= '_ajax' . $View->getDefaultExtension();
		}
		else
		{
			$layout    = $path . 'default' . $View->getDefaultExtension();
			$template .= $View->getDefaultExtension();
		}

		$process->setLayout( $layout );
		$process->setTemplate( $template );
		$process->setAutoRender( true );
		$View->set( 'baseUrl', $baseUrl );
	}

	function onError( $message )
	{
		die( $message );
	}

	function onDatabaseError( $message = null )
	{
		$this->onError( 'DATABASE ERROR' . ( $message ? ' : ' . $message : null ) );
	}

	function onAccessError( $message = null )
	{
		$this->onError( 'ACCESS DENIED' . ( $message ? ' : ' . $message : null ) );
	}

	function enableCaching( &$process, $caller, $lifetime = 86400, $append = null )
	{
		$view = $process->getTemplate();
		$path = PhpMew2::getPath( 'cache' )
		      . $process->getControllerName() . '_'
		      . $process->getActionName() . $append . '.html';

		if ( file_exists( $path ) )
		{
			if ( filemtime( $caller ) <= filemtime( $path )
			|| filemtime( $view ) <= filemtime( $path ) )
			{
				return;
			}
		}

		$caching = Array(
			'lifetime' => $lifetime,
			'path'     => $path
		);
		$process->addBeforeFilter(
			PhpMew2::get( 'Mew/View/Cache/Default/Loader', null, $caching )
		);
		$process->addAfterFilter(
			PhpMew2::get( 'Mew/View/Cache/Default/Recorder', null, $caching )
		);
	}
}


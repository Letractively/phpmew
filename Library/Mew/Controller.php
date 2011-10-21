<?php

/*
 */
class Mew_Controller
{
	public function init( &$process )
	{
	}

	protected function redirect( $uri = null )
	{
		header('Location: ' . $uri);
	}

	public function onActionNotFound( &$process )
	{
		die('Action Not Found');
	}

	protected function onError( $message )
	{
		$this->onCriticalError($message);
	}

	protected function onCriticalError( $message )
	{
		die($message);
	}

	protected function onExceptionError( $message )
	{
		throw new Exception($message);
	}
}


<?php

/*
	example main pages
 */

class Controller_Home extends AppController
{
	function init( &$process )
	{
		parent::init( $process );
	}

	function indexAction( &$process )
	{
		$SomeModel = PhpMew2::get('SomeModel');
		$View      = $process->getView();

		$View->set( 'all_data', $SomeModel->getAll() );
	}
}


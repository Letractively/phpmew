<?php
// example
/* bootstrap */
//php environment settings
error_reporting(E_ALL | E_STRICT);
session_cache_limiter('nocache');
session_cache_expire('180');
date_default_timezone_set('Pacific/Auckland');

//include PhpMew2 base class
include_once '../Library/PhpMew2.php';
include_once '../Library/Default.php';
include_once '../Application/AppController.php';
include_once '../Application/Config.php';
include_once '../Application/Route.php';

try
{
	//adding application specific paths
	PhpMew2::addPath('app', dirname(__FILE__) . '/../Application');
	PhpMew2::addPath('model', PhpMew2::getPath('app') . 'Model');
	PhpMew2::addPath('view', PhpMew2::getPath('app') . 'View');
	PhpMew2::addPath('temp', PhpMew2::getPath('app') . 'Temp');
	PhpMew2::addPath('cache', PhpMew2::getPath('app') . 'Cache');

	//load additional classes
	PhpMew2::load('Mew/Database/Adapter/Mysql');

	//change session save path to own tmp directory
	session_save_path( PhpMew2::getPath('temp') );
	session_start();

	//set default db adapter
	Mew_Database::setDefaultAdapter( new Mew_Database_Adapter_Mysql($mysqlOption) );

	//dispatch
	Mew_Dispatcher::dispatch( $Router->route( Mew_Request_Uri::getRequest() ), $Process );
}
catch ( Exception $e )
{
	echo '<div>' . $e->getMessage() . '</div>';
}

?>

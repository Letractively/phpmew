<?php

//add directory path that the library to load classes from
PhpMew2::addPath('_mewlib', dirname(__FILE__));

//load base Mew classes for default mode
PhpMew2::load('Mew/Controller', '_mewlib', true);
PhpMew2::load('Mew/Dispatcher', '_mewlib', true);
PhpMew2::load('Mew/Process/Mvc', '_mewlib', true);
PhpMew2::load('Mew/Request/Uri', '_mewlib', true);

//load database and model classes
PhpMew2::load('Mew/Database', '_mewlib');
PhpMew2::load('Mew/Model/Database', '_mewlib');

//load router
$Router = PhpMew2::get('Mew/Router/PrettyUrl', '_mewlib');

//default routes
$Router->addRoute(Array( '.*', Array('controller' => 'Home'), 'action' => 'Index', Array() ));
$Router->addRoute(Array( '(\w+)', Array('action' => 'Index'), Array('controller') ));
$Router->addRoute(Array( '(\w+)/(\d+)', Array('action' => 'Index'), Array('controller', 'id') ));
$Router->addRoute(Array( '(\w+)/(\w+)', Array(), Array('controller', 'action') ));
$Router->addRoute(Array( '(\w+)/(\w+)/(\d+)', Array(), Array('controller', 'action', 'id') ));

//create a default mvc process
$Process = new Mew_Process_Mvc;

?>

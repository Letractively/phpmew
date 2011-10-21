<?php

/*
 */
class Mew_Router_PrettyUrl
{
	protected $routes = Array();

	public function addRoute( $route )
	{
		array_push( $this->routes, $route );
	}

	public function clearRoutes()
	{
		$this->routes = Array();
	}

	public function route( $request, $method = 'Mew/Map/RegularExpression' )
	{
		$match  = null;
		$mapper = PhpMew2::get( $method );

		while ( ( $route = array_pop( $this->routes ) ) != null )
		{
			if ( $mapper->match( $route, $request, $match ) )
			{
				break;
			}
		}

		return $match;
	}
}


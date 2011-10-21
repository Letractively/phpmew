<?php

/*
 */
final class Mew_Process_Mvc
{
	public static $DEFAULT_CONTROLLER = 'Main';
	public static $DEFAULT_ACTION     = 'index';
	public static $ACTION_PREFIX      = null;
	public static $ACTION_POSTFIX     = 'Action';
	public static $ACTION_NOT_FOUND   = 'onActionNotFound';

	protected $filters        = Array( 'before' => Array(), 'after' => Array() );
	protected $helpers        = Array();
	protected $components     = Array();
	protected $controller     = null;
	protected $action         = null;
	protected $controllerName = null;
	protected $actionName     = null;
	protected $parameters     = Array();
	protected $view           = null;
	protected $template       = null;
	protected $layout         = null;
	protected $autoRender     = false;
	protected $noController   = null;
	protected $runningMode    = 'PARENT';
	protected $result         = null;

	function run()
	{
		$output = null;
		$this->controller->init( $this );

		foreach( $this->filters['before'] as $filter )
		{
			//if filter throws an exception silently exit
			//for ex. caching loader plugin
			try
			{
				$this->parameters = $filter->run( $this->parameters );
			}
			catch (Exception $e)
			{
				//die();
				return;
			}
		}

		$this->result = $this->controller->{$this->action}( $this );

		//if auto render, give rendered page as input to filter
		//to work on output before flushing to client ie. caching filter
		if ( $this->autoRender === true )
		{
			$output = $this->view->render( $this->template, $this->layout );
		}

		foreach( $this->filters['after'] as $filter )
		{
			$output = $filter->run( $output );
		}

		if ( $this->autoRender === true )
		{
			echo $output;
		}

		return $this->result;
	}

	function create( $setting = Array(), $mode = 'PARENT' )
	{
		$setting['controller'] = isset( $setting['controller'] ) ? $setting[ 'controller' ] : null;
		$setting['action']     = isset( $setting['action'] )     ? $setting[ 'action' ] : null;
		$this->setRunningMode( $mode );


		if ( !$this->setController( $setting['controller'] ) )
		{
			return false;
		}

		if ( !$this->setAction( $setting['action'] ) )
		{
			return false;
		}

		//do we really need to unset these?
		unset( $setting['controller'] );
		unset( $setting['action'] );
		$this->setParameters( $setting );
		return true;
	}

	function call( $controller, $action, $parameters = Array() )
	{
		$process = new Mew_Process_Mvc;
		$process->create( Array(
			'controller' => $controller,
			'action'     => $action
		), 'CHILD' );
		$process->setParameters( $parameters );

		//ob_end_flush();
		//flush();
		ob_start();
		$result = $process->run();
		$output = ob_get_contents();
		ob_end_clean();
		ob_start();

		unset( $process );

		if ( empty( $output ) )
		{
			return $result;
		}
		else
		{
			return $output;
		}
	}

	function setController( $value = null )
	{
		$value = strtolower( $value );
		$class = 'Controller/' . ucfirst( $value );
		$this->controllerName = $value;
		$this->controller     = PhpMew2::get( $class, null, null, false );

		if ( !$this->controller )
		{
			if ( $this->noController )
			{
				$this->noController->run();
			}
			else
			{
				throw new Exception( 'CONTROLLER NOT FOUND' );
			}

			return false;
		}

		return true;
	}

	function setAction( $value = null  )
	{
		$value            = ( $value == null ) ? self::$DEFAULT_ACTION : strtolower( $value );
		$this->actionName = $value;
		$this->action     = self::$ACTION_PREFIX . $value;

		if ( $this->runningMode == 'PARENT' )
		{
			$this->action .= self::$ACTION_POSTFIX;
		}

		if ( !method_exists( $this->controller, $this->action ) )
		{
			if ( !method_exists( $this->controller, self::$ACTION_NOT_FOUND ) )
			{
				throw new Exception('ACTION NOT FOUND');
				return false;
			}

			$this->action = self::$ACTION_NOT_FOUND;
		}

		return true;
	}

	function setParameters( $value = Array() )
	{
		$this->parameters = $value;
	}

	function setAutoRender( $bool = true )
	{
		$this->autoRender = $bool;
	}

	function setBeforeFilters( $value = Array() )
	{
		$this->filters['before'] = $value;
	}

	function addBeforeFilter( $value )
	{
		array_push( $this->filters['before'], $value );
	}

	function setAfterFilters( $value = Array() )
	{
		$this->filters['after'] = $value;
	}

	function addAfterFilter( $value )
	{
		array_push( $this->filters['after'], $value );
	}

	function setHelpers( $value = Array() )
	{
		$this->helpers = $value;
	}

	function setView( $value = null )
	{
		$this->view = $value;
	}

	function setTemplate( $value = null )
	{
		$this->template = $value;
	}

	function setLayout( $value = null )
	{
		$this->layout = $value;
	}

	function setRunningMode( $mode = 'CHILD' )
	{
		if ( $mode == 'PARENT' || $mode == 'CHILD' )
		{
			$this->runningMode = $mode;
		}
	}

	function onNoController( $callback = null )
	{
		if ( is_object( $callback ) && method_exists( $callback, 'run' ) )
		{
			$this->noController = $callback;
		}
	}

	function getView()
	{
		return $this->view;
	}

	function getComponent( $name )
	{
		return null; //TODO
	}

	function getHelper( $name )
	{
		return null; //TODO
	}

	function getControllerName()
	{
		return $this->controllerName;
	}

	function getActionName()
	{
		return $this->actionName;
	}

	function getParameters()
	{
		return $this->parameters;
	}

	function getParameter( $key, $default = null )
	{
		return array_key_exists( $key, $this->parameters ) ? $this->parameters[ $key ] : $default;
	}

	function getDefaultTemplate()
	{
		return $this->controllerName . '/' . $this->actionName;
	}

	function getTemplate()
	{
		return $this->template;
	}

	function getLayout()
	{
		return $this->layout;
	}
}


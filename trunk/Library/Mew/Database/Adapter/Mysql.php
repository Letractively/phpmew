<?php

/*
*/

PhpMew2::load('Mew/Database/Adapter');

class Mew_Database_Adapter_Mysql extends Mew_Database_Adapter
{
	protected $link;
	protected $result;
	protected $database;
	protected $errorCode;
	protected $errorMessage;
	protected $lastQueryString;
	protected $lastId;
	protected $option;

	public function __construct( $option = null )
	{
		if ( $option != null )
		{
			$this->setOption($option);
		}
	}

	public function connect()
	{
		if ( $this->link )
		{
			return true;
		}

		if ( !isset( $this->option['host'] ) )
		{
			$this->option['host'] = 'localhost';
		}

		if ( !isset( $this->option['username'] ) )
		{
			throw new Exception('INSUFFICIENT DATABASE CONFIGURATION');
			$this->errorMessage = 'username is not set';
			return false;
		}

		if ( !isset( $this->option['password'] ) )
		{
			$this->option['password'] = '';
		}

		//use mysql_pconnect instead?
		$this->link = mysql_connect(
			$this->option['host'],
			$this->option['username'],
			$this->option['password']
		);

		if ( !$this->link )
		{
			throw new Exception('DATABASE CONNECTION ERROR');
		}
		else if ( isset( $this->option['database'] ) )
		{
			$this->select_database( $this->option['database'] );
		}

		return $this->link;
	}

	public function close()
	{
		if ( $this->link )
		{
			mysql_close($this->link);
		}
	}

	public function select_database( $name )
	{
		$this->database = $name;
		return mysql_select_db($name, $this->link);
	}

	public function query( $sql )
	{
		if ( !$this->link )
		{
			if ( !$this->connect() )
			{
				die('DATABASE CONNECTION ERROR');
			}
		}

		$this->sql    = $sql;
		$this->result = mysql_query($sql, $this->link);

		if ( !$this->result )
		{
			$this->errorCode    = mysql_errno($this->link);
			$this->errorMessage = mysql_error($this->link);
			return false;
		}

		return true;
	}

	public function escape( $input )
	{
		return mysql_real_escape_string($input);
	}

	public function fetch()
	{
		if ( !$this->result )
		{
			return false;
		}

		return mysql_fetch_object($this->result);
	}

	public function succeed()
	{
		return $this->result;
	}

	public function getLastError()
	{
		return $this->errorMessage;
	}

	public function getLastInsertId()
	{
		return mysql_insert_id($this->link);
	}

	public function getLastSql()
	{
		return $this->sql;
	}

	public function getRowCount()
	{
		$command = strtolower( substr($this->sql, 0, strpos(' ', $this->sql)) );

		if ( strcmp($command, 'select') == 0 )
		{
			return mysql_num_rows($this->result);
		}
		else
		{
			return mysql_affected_rows($this->result);
		}
	}

	public function setOption( $option )
	{
		$this->option = $option;
	}

	public function getCurrentDatabase()
	{
		return $this->database;
	}
}


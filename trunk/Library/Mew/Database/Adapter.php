<?php

/*
*/

abstract class Mew_Database_Adapter
{
	protected $link;
	protected $result;
	protected $database;
	protected $errorCode;
	protected $errorMessage;
	protected $lastQueryString;
	protected $lastId;
	protected $option;

	abstract public function connect();
	abstract public function close();
	abstract public function select_database( $name );
	abstract public function query( $sql );
	abstract public function escape( $input );
	abstract public function fetch();
	abstract public function succeed();
	abstract public function getLastError();
	abstract public function getLastInsertId();
	abstract public function getLastSql();
	abstract public function getRowCount();
	abstract public function setOption( $option );
	abstract public function getCurrentDatabase();
}


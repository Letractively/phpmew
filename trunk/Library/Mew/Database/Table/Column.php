<?php

/*
*/

PhpMew2::load('Mew/Database/Table/Column/Type');

class Mew_Database_Table_Column
{
	protected $name;
	protected $type;
	protected $default;
	protected $auto;
	protected $primary;
	protected $foreign;

	function __construct( $name, $type, $nullable = true, $default = null, $primary = false, $foreign = null, $auto_increment = false )
	{
		$this->name     = $name;
		$this->type     = $type;
		$this->nullable = $nullable;
		$this->default  = $default;
		$this->auto     = $auto_increment;
		$this->primary  = $primary;
		$this->foreign  = $foreign;
	}

	function getName()
	{
		return $this->name;
	}

	function getType()
	{
		return $this->type;
	}

	function isNullable()
	{
		return $this->nullable;
	}

	function getDefault()
	{
		return $this->default;
	}

	function isAutoIncrement()
	{
		return $this->auto;
	}

	function isPrimary()
	{
		return $this->primary;
	}

	function isForeign()
	{
		return $this->foreign;
	}
}

//shorthand
class Column extends Mew_Database_Table_Column
{
}


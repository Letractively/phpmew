<?php

/*
 */
class Mew_Database_Table_Column_Type
{
	protected $type;
	protected $length;

	public function __construct( $type, $length = 0 )
	{
		$this->type   = strtolower($type);
		$this->length = (int) $length;
	}

	public function getLength()
	{
		return $this->length;
	}

	public function isInteger()
	{
		return ( $this->type == 'int' ? true : false );
	}

	public function isVarchar()
	{
		return ( $this->type == 'varchar' ? true : false );
	}

	public function isChar()
	{
		return ( $this->type == 'char' ? true : false );
	}

	public function isEnum()
	{
		return ( $this->type == 'enum' ? true : false );
	}

	public function isText()
	{
		return ( $this->type == 'text' ? true : false );
	}

	public function isBlob()
	{
		return ( $this->type == 'blob' ? true : false );
	}

	public function isDateTime()
	{
		return ( $this->type == 'datetime' ? true : false );
	}
}

//shorthand
class Column_Type extends Mew_Database_Table_Column_Type
{
}


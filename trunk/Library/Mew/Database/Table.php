<?php

/*
 */

PhpMew2::load('Mew/Database/Table/Column');

class Mew_Database_Table
{
	protected $name;
	protected $columns = Array();

	public function __construct( $name, $columns = Array() )
	{
		$this->name    = trim( $name );
		$this->columns = $columns;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getCreateSql()
	{
		$primary_keys = Array();

		if ( empty( $this->name ) || !count( $this->columns ) )
		{
			return null;
		}

		$sql = 'CREATE TABLE `' . $this->name . '` (';

		foreach ( $this->columns as $key => $column )
		{
			if ( $key )
			{
				$sql .= ', ';
			}

			$sql .= '`' . $column->getName() . '`';

			if ( !$column->isNullable() )
			{
				$sql .= ' not null';
			}

			if ( $column->getDefault() !== null )
			{
				$sql .= ' default \'' . $column->getDefault() . '\'';
			}

			if ( $column->isAutoIncrement() )
			{
				$sql .= ' auto_increment';
			}

			if ( $column->isPrimaryKey() )
			{
				array_push( $primey_keys, $column->getName() );
			}
		}

		if ( count( $primary_keys ) )
		{
			$sql .= ', primary key('
			      . implode(',', $primary_keys)
			      . ')';
		}

		$sql .= ');';

		return $sql;
	}
}


<?php

/*
 */
class Mew_Database_Sql_Generator_Array
{
	protected $database = null;
	protected $table    = null;
	protected $data     = Array();
	static    $COMMANDS = Array('select', 'insert', 'udpate', 'delete');

	function clearAll()
	{
		$this->data = Array(
			'command'   => null,
			'option'    => Array(),
			'table'     => Array(),
			'fields'    => Array(),
			'join'      => Array(),
			'updateset' => Array(),
			'values'    => Array(),
			'where'     => Array(),
			'groupby'   => Array(),
			'orderby'   => Array(),
			'limit'     => null,
			'offset'    => null,
		);
	}

	function setDefaultDatabase( $name = null )
	{
		$this->database = $name;
		return $this;
	}

	function setDefaultTable( $name )
	{
		$this->table = $name;
		return $this;
	}

	function isSelectQuery()
	{
		$this->data['command'] = 'select';
		return $this;
	}

	function isInsertQuery()
	{
		$this->data['command'] = 'insert';
		return $this;
	}

	function isUpdateQuery()
	{
		$this->data['command'] = 'update';
		return $this;
	}

	function isDeleteQuery()
	{
		$this->data['command'] = 'delete';
		return $this;
	}

	function addOption( $input )
	{
		array_push( $this->data['option'], trim($input) );
		return $this;
	}

	function addTable( $name, $alias = null, $database = null )
	{
		array_push(
			$this->data['table'],
			Array( 'name' => trim($name), 'alias' => $alias, 'database' => $database )
		);
		return $this;
	}

	function addField( $name, $alias = null, $table = null )
	{
		array_push(
			$this->data['fields'],
			Array( 'name' => $name , 'alias' => $alias, 'table' => $table )
		);
		return $this;
	}

	function addJoin( $sql, $on, $alias = null, $type = 'join' )
	{
		array_push(
			$this->data['join'],
			Array( 'type' => $type, 'sql' => $name, 'alias' => $alias, 'on' => $on )
		);
		return $this;
	}

	function addLeftJoin( $sql, $on, $alias = null )
	{
		return $this->addJoin( $sql, $on, $alias, 'left join' );
	}

	function addRightJoin( $sql, $on, $alias = null )
	{
		return $this->addJoin( $sql, $on, $alias, 'right join' );
	}

	function addOuterJoin( $sql, $on, $alias = null )
	{
		return $this->addJoin( $sql, $on, $alias, 'outer join' );
	}

	function addInnerJoin( $sql, $on, $alias = null )
	{
		return $this->addJoin( $sql, $on, $alias, 'inner join' );
	}

	function addUpdateSet( $field, $value )
	{
		//array_push( $this->data['updateset'], Array( $field => $value ) );
		$this->data['updateset'][ $field ] = $value;
		return $this;
	}

	function addValues( $values = Array() )
	{
		if ( count( $values ) )
		{
			array_push( $this->data['values'], $values );
		}

		return $this;
	}

	function addWhere( $where, $relation = null )
	{
		array_push(
			$this->data['where'],
			Array( 'where' => $where, 'relation' => $relation )
		);
		return $this;
	}

	function setWhere( $where )
	{
		$this->data['where'] = $where;
		return $this;
	}

	function addGroupBy( $field, $table = null )
	{
		array_push(
			$this->data['groupby'],
			Array( 'field' => $field, 'table' => $table )
		);
		return $this;
	}

	function setGroupBy( $groupby )
	{
		$this->data['groupby'] = $groupby;
		return $this;
	}

	function addOrderBy( $field, $order = 'ASC', $table = null )
	{
		array_push(
			$this->data['orderby'],
			Array( 'field' => $field, 'order' => $order, 'table' => $table )
		);
		return $this;
	}

	function setOrderBy( $orderby )
	{
		$this->data['orderby'] = $orderby;
		return $this;
	}

	function setLimit( $limit = 10 )
	{
		$this->data['limit'] = $limit;
		return $this;
	}

	function setOffset( $value = 0 )
	{
		$this->data['offset'] = $value;
		return $this;
	}

	function get()
	{
		if ( empty( $this->data['command'] ) )
		{
			throw new Exception('SQL COMMAND NOT SET');
		}
		else if ( !in_array( $this->data['command'], self::$COMMANDS ) )
		{
			throw new Exception('INVALID SQL COMMAND');
		}

		$sql = $this->data['command'];

		if ( $this->data['command'] == 'insert' )
		{
			$sql .= ' into ';
		}
		else if ( $this->data['command'] == 'select' )
		{
			$fields = Array();

			if ( !count( $this->data['fields'] ) )
			{
				$sql .= ' * ';
			}
			else
			{
				foreach ( $this->data['fields'] as $field )
				{
					$_field = null;

					if ( isset( $field['table'] ) && $field['table'] !== null )
					{
						$_field = '`' . $field['table'] . '`.';
					}

					$_field .= '`' . $field['name'] . '`';

					if ( isset( $field['alias'] ) && $field['alias'] !== null )
					{
						$_field .= ' as ' . $field['alias'];
					}

					array_push($fields, $_field);
				}

				$sql .= implode(',', $fields);
			}

			$sql .= ' from ';
		}

		$sql .= '`' . $this->table . '` ';

		if ( count( $this->data['table'] ) )
		{
			foreach ( $this->data['table'] as $table )
			{
				$sql .= ', ';

				if ( $table['database'] !== null )
				{
					$sql .= '`' . $table['database'] . '`.';
				}

				$sql .= $table['name'];

				if ( $table['alias'] !== null )
				{
					$sql .= ' as `'. $table['alias'] . '`';
				}
			}
		}

		if ( count( $this->data['join'] ) )
		{
			foreach ( $this->data['join'] as $join )
			{
				$sql .= $join['type'] . '(' . $join['sql'] . ')';

				if ( $join['alias'] !== null )
				{
					$sql .= ' as ' . $join['alias'];
				}

				$sql .= ' on (' . $join['on'] . ') ';
			}
		}

		if ( $this->data['command'] == 'insert' )
		{
			if ( !count( $this->data['values'] ) )
			{
				throw new Exception('NO DATA FOR INSERT');
			}

			$sql   .= ' values';
			$first1 = true;
			$first2 = true;

			foreach ( $this->data['values'] as $values )
			{
				if ( !$first1 )
				{
					$sql .= ', ';
				}

				$first1  = false;
				$sql    .= '(';

				foreach ( $values as $value )
				{
					if ( !$first2 )
					{
						$sql .= ', ';
					}

					$first2  = false;
					$sql    .= '\'' . $value . '\'';
				}

				$sql .= ')';
			}
		}
		else if ( $this->data['command'] == 'update' )
		{
			if ( !count( $this->data['updateset'] ) )
			{
				throw new Exception('NO DATA FOR UPDATE');
			}

			$sql   .= ' set ';
			$first  = true;

			foreach ( $this->data['updateset'] as $key => $value )
			{
				if ( !$first )
				{
					$sql .= ', ';
				}

				$first  = false;
				$sql   .= '`' . $key . '` = \'' . $value . '\'';
			}
		}

		if ( is_array( $this->data['where'] ) && count( $this->data['where'] ) )
		{
			$sql .= ' where';

			foreach ( $this->data['where'] as $value )
			{
				$value['relation'] = trim( $value['relation'] );

				if ( $value['relation'] !== null )
				{
					$sql .= $value['relation'];
				}

				$sql .= ' (' . $value['where'] . ') ';
			}
		}
		else if ( !empty( $this->data['where'] ) )
		{
			$sql .= ' where ' . $this->data['where'];
		}

		if ( is_array( $this->data['groupby'] ) && count( $this->data['groupby'] ) )
		{
			$sql .= ' group by ';

			foreach ( $this->data['groupby'] as $key => $groupby )
			{
				if ( $key )
				{
					$sql .= ', ';
				}

				if ( $groupby['table'] !== null )
				{
					$sql .= '`' . $groupby['table'] . '`.';
				}

				$sql .= '`'. $groupby['field'] . '`';
			}
		}
		else if ( is_string( $this->data['groupby'] ) )
		{
			$sql .= ' group by ' . $this->data['groupby'];
		}

		if ( is_array( $this->data['orderby'] ) && count( $this->data['orderby'] ) )
		{
			$sql .= ' order by ';

			foreach ( $this->data['orderby'] as $key => $orderby )
			{
				if ( $key )
				{
					$sql .= ', ';
				}

				if ( $orderby['table'] != null )
				{
					$sql .= '`' . $orderby['table'] . '`.';
				}

				$sql .= '`' . $orderby['field'] . '`';
			}
		}
		else if ( is_string( $this->data['orderby'] ) )
		{
			$sql .= ' order by ' . $this->data['orderby'];
		}

		if ( $this->data['limit'] )
		{
			$sql .= ' limit ' . $this->data['limit'];
		}

		if ( $this->data['offset'] )
		{
			$sql .= ' offset ' . $this->data['offset'];
		}

		return $sql;
	}
}


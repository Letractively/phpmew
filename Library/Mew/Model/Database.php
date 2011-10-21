<?php

/*
 */

PhpMew2::load('Mew/Database');
PhpMew2::load('Mew/Database/Table');
PhpMew2::load('Mew/Database/Sql/Generator/Array');

class Mew_Model_Database
{
	protected $_Adapter   = null;
	protected $_Database  = null;
	protected $_Table     = null;
	protected $_Error     = null;
	protected $_Generator = null;

	public function __construct( &$adapter = null )
	{
		if ( $adapter == null )
		{
			$adapter = Mew_Database::getDefaultAdapter();
		}

		if ( $adapter == null )
		{
			throw new Exception('NO ADAPTER');
		}

		$this->_Adapter = $adapter;

		if ( $this->_Database === null )
		{
			$this->_Database = $this->_Adapter->getCurrentDatabase();
		}
		else if ( !$this->_Adapter->select_database( $this->_Database ) )
		{
			throw new Exception('SELECT DATABASE ERROR');
		}

		$this->init();
		$this->_Generator = new Mew_Database_Sql_Generator_Array;
		$this->_Generator->setDefaultDatabase( $this->_Database );

		if ( is_object( $this->_Table ) )
		{
			$this->_Generator->setDefaultTable( $this->_Table->getName() );
		}
		else if ( is_string( $this->_Table ) )
		{
			$this->_Generator->setDefaultTable( $this->_Table );
		}
		else
		{
			$this->_Generator->setDefaultTable( strtolower( get_class( $this )  ) );
		}

		$this->_Generator->clearAll();
	}

	protected function init()
	{
	}

	public function query( $sql )
	{
		if ( !$this->_Adapter->query( $sql ) )
		{
			$this->setError( $this->_Adapter->getLastError() );
			return false;
		}

		return true;
	}

	public function find()
	{
		$one       = false;
		$direct    = false;
		$i         = 0;
		$count     = func_num_args();
		$arguments = func_get_args();
		$sql       = null;
		$sqlArray  = Array();
		$this->_Generator->clearAll();
		$this->_Generator->isSelectQuery();

		while ( $i < $count )
		{
			$command = trim( $arguments[ $i ] );

			switch ( $command )
			{
				case 'sql:':
				case 'select:':
				case 'where:':
				case 'groupby:':
				case 'orderby:':
				case 'offset:':
				case 'limit:':
				{
					if ( $count < $i + 1 )
					{
						throw new Exception('NOT ENOUGH ARGUMENT');
					}
				}
				case 'one:':
				{
					break;
				}
				default:
				{
					throw new Exception('UNKNOWN ARGUMENT');
					break;
				}
			}

			$i++;

			switch ( $command )
			{
				case 'sql:':
				{
					$sql    = $arguments[ $i ];
					$direct = true;
					break;
				}
				case 'select:':
				{
					$fields = explode(',', $arguments[ $i ]);

					foreach ($fields as $field)
					{
						$field = trim($field);
						$this->_Generator->addField($field, null, null);
					}

					break;
				}
				case 'where:':
				{
					$this->_Generator->setWhere( $arguments[ $i ] );
					break;
				}
				case 'groupby:':
				{
					$this->_Generator->setGroupBy( $arguments[ $i ] );
					break;
				}
				case 'orderby:':
				{
					$this->_Generator->setOrderBy( $arguments[ $i ] );
					break;
				}
				case 'limit:':
				{
					$this->_Generator->setLimit( $arguments[ $i ] );
					break;
				}
				case 'offset:':
				{
					$this->_Generator->setOffset( $arguments[ $i ] );
					break;
				}
				case 'one:':
				{
					$one = true;

					if ( !$direct )
					{
						$this->_Generator->setLimit(1);
					}
					else if ( strpos( $sql, 'limit' ) !== false )
					{
						$sql .= ' limit 1';
					}

					break;
				}
				default:
				{
					break;
				}
			}

			$i++;
		}

		if ( !$direct )
		{
			$sql = $this->_Generator->get();
		}

		$rows = Array();

		if ( $this->query( $sql ) )
		{
			while ( $row = $this->_Adapter->fetch() )
			{
				array_push( $rows, (object) $row );
			}
		}

		if ( $one === true )
		{
			if ( count( $rows ) )
			{
				return $rows[0];
			}
			else
			{
				return new stdClass;
			}
		}
		else
		{
			return $rows;
		}
	}

	public function create()
	{
		$exit      = false;
		$once      = false;
		$i         = 0;
		$count     = func_num_args();
		$arguments = func_get_args();
		$this->_Generator->clearAll();
		$this->_Generator->isInsertQuery();

		while ( $i < $count )
		{
			if ( is_string( $arguments[ $i ] ) )
			{
				$command = trim( $arguments[ $i ] );

				switch ( $command )
				{
					case 'sql:':
					{
						if ( ++$i >= $count )
						{
							throw new Exception('NOT ENOUGH ARGUMENT');
						}

						if ( !is_string( $arguments[ $i ] ) )
						{
							throw new Exception('INVALID ARGUMENT');
						}

						$sql  = $arguments[ $i ];
						$exit = true;
					}
					case 'one:':
					{
						$one = true;
					}
				}
			}
			else if ( is_array( $arguments[ $i ] ) )
			{
				if ( $one )
				{
					$this->_Generator->addValues( $arguments[ $i ] );
				}
				else
				{
					foreach ( $arguments[ $i ] as $data )
					{
						$this->_Generator->addValues( $arguments[ $i ] );
					}
				}
			}
			else
			{
				throw new Exception('INVALID ARGUMENT');
			}

			if ( $exit )
			{
				break;
			}

			$i++;
		}

		if ( !$exit )
		{
			$sql = $this->_Generator->get();
		}

		return $this->query( $sql );
	}

	public function update()
	{
		$exit      = false;
		$i         = 0;
		$count     = func_num_args();
		$arguments = func_get_args();
		$this->_Generator->clearAll();
		$this->_Generator->isUpdateQuery();

		while ( $i < $count )
		{
			if ( is_string( $arguments[ $i ] ) )
			{
				$command = trim( $arguments[ $i ] );

				switch ( $command )
				{
					case 'sql:':
					{
						if ( ++$i >= $count )
						{
							throw new Exception('NOT ENOUGH ARGUMENT');
						}

						if ( !is_string( $arguments[ $i ] ) )
						{
							throw new Exception('INVALID ARGUMENT');
						}

						$sql  = $arguments[ $i ];
						$exit = true;
						break;
					}
					case 'where:':
					{
						if ( ++$i >= $count )
						{
							throw new Exception('NOT ENOUGH ARGUMENT');
						}

						if ( !is_string( $arguments[ $i ] ) )
						{
							throw new Exception('INVALID ARGUMENT');
						}

						$this->_Generator->addWhere( $arguments[ $i ] );
						break;
					}
					default:
					{
						throw new Exception('UNKNOWN COMMAND');
						break;
					}
				}
			}
			else if ( is_array( $arguments[ $i ] ) && count( $arguments[ $i ] ) )
			{
				foreach ( $arguments[ $i ] as $key => $value )
				{
					$this->_Generator->addUpdateSet( $key, $value );
				}
			}
			else
			{
				throw new Exception('INVALID ARGUMENT');
			}

			if ( $exit )
			{
				break;
			}

			$i++;
		}

		if ( !$exit )
		{
			$sql = $this->_Generator->get();
		}

		return $this->query( $sql );
	}

	public function remove()
	{
		//TODO
		$this->_Generator->clearAll();
		$this->_Generator->isDeleteQuery();
	}

	public function succeed()
	{
		return $this->_Adapter->succeed();
	}

	public function getError()
	{
		return $this->_Error;
	}

	public function getLastInsertId()
	{
		return $this->adapter->getLastInsertId( $this->tableName );
	}

	public function getAdapter()
	{
		return $this->_Adapter;
	}

	public function setAdapter( Mew_Database_Adapter $adapter )
	{
		$this->_Adapter = $adapter;
	}

	public function getSqlGenerator()
	{
		return $this->_Generator;
	}

	public function getTable()
	{
		return $this->_Table;
	}

	public function setTable( Mew_Database_Table $table )
	{
		$this->_Table = $table;
	}

	protected function setError( $message = null )
	{
		if ( $message === null )
		{
			$this->_Error = $this->_Adapter->getLastError();
		}
		else
		{
			$this->_Error = $message;
		}
	}
}


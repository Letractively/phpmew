<?php

// example model

class SomeModel extends Mew_Model_Database
{
	protected $_Table = 'my_table';

	function getAll()
	{
		$items = new stdClass;
		$rows  = $this->find();

		foreach ( $rows as $row )
		{
			$items->{$row->title} = $row;
		}

		return $items;
	}

	function get( $item )
	{
		$rows = $this->find('where:', "title='{$item}'");

		if ( count( $rows ) )
		{
			return $rows[0];
		}
		else
		{
			return (object) Array(
				'title'   => null,
				'content' => null,
				'created' => null,
				'updated' => null);
		}
	}
}


<?php

class Mew_View_Helper_Pagination
{
	public $start       = 1;
	public $end         = 1;
	public $current     = 1;
	public $total       = 0;
	public $total_pages = 0;
	public $item_count  = 15;
	public $page_count  = 0;

	function run()
	{
		$pagination        = $this->calculate($this->total, $this->current, $this->item_count, $this->page_count);
		$this->start       = $pagination->start;
		$this->end         = $pagination->end;
		$this->total_pages = $pagination->total_pages;
	}

	function calculate( $total, $page = 1, $items = 15, $pages = 0 )
	{
		$pagination              = new stdClass;
		$pagination->start       = 1;
		$pagination->end         = 1;
		$pagination->current     = $page;
		$pagination->total_pages = 1;
		$pagination->items       = $items;
		$pagination->pages       = $pages;

		if ( $total < 0 )
		{
			$total = 0;
		}

		if ( $page < 1 )
		{
			$page = 1;
		}

		if ( $total > $items )
		{
			$pagination->end = $pagination->total_pages = ceil($total / $items);
		}

		if ( $page > 1 && $pages && $page != $pages )
		{
			if (( $page % $pages ))
			{
				$pagination->start = $page - (($page % $pages) - 1);
			}
			else
			{
				$pagination->start = $page - ($page - 1) % $pages;
			}
		}
		else if ( $page > 1 && $pages )
		{
			$pagination->start = $page - $pages + 1;
		}

		if ( $pages )
		{
			$pagination->end = ($pagination->total_pages < ($pagination->start + $pages)) ?
			                   $pagination->total_pages : ($pagination->start + $pages - 1);
		}

		return $pagination;
	}

}


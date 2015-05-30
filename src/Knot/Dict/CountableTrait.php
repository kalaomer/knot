<?php namespace Knot\Dict;

trait CountableTrait {

	protected $data = [ ];


	/**
	 * @param int $mode
	 *
	 * @return int
	 */
	public function count($mode = COUNT_NORMAL)
	{
		return count($this->data, $mode);
	}

}
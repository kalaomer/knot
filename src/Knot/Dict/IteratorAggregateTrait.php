<?php namespace Knot\Dict;

use ArrayIterator;

trait IteratorAggregateTrait {

	protected $data = [ ];


	/**
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->data);
	}
}
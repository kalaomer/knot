<?php namespace Knot\Dict;

use ArrayIterator;

trait IteratorAggregateTrait {

	/**
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->data);
	}
}
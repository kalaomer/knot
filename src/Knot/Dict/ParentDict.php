<?php namespace Knot\Dict;

use Knot\Dict;

/**
 * Class ParentDict
 * @package Knot\Dict
 */
class ParentDict extends Dict {

	/**
	 * @return $this
	 */
	public function kill()
	{
		$this->data = [ ];

		return $this;
	}

}
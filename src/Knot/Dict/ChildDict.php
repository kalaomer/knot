<?php namespace Knot\Dict;

use Knot\Dict;

class ChildDict extends Dict {

	/**
	 * @return self
	 */
	public function kill()
	{
		$this->parentArray->del($this->path());
		$this->data = [ ];

		return $this;
	}


	/**
	 * @return ParentDict
	 */
	public function parent()
	{
		return $this->parentArray;
	}


	/**
	 * In ChildArray's child's parent is parent array.
	 *
	 * @return ParentDict
	 */
	public function childParent()
	{
		return $this->parentArray;
	}
}

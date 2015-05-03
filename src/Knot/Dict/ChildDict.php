<?php

namespace Knot\Dict;

class ChildDict extends AbstractBody {

	/**
	 * @return self
	 */
	public function kill()
	{
		$this->parentArray->del($this->path());
		$this->data = [];

		return $this;
	}

	/**
	 * @return self
	 */
	public function parent()
	{
		return $this->parentArray;
	}

	/**
	 * In ChildArray's child's parent is parent array.
	 * @return $this
	 */
	public function childParent()
	{
		return $this->parentArray;
	}
}

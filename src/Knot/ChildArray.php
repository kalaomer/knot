<?php

namespace Knot;

class ChildArray extends ParentArray {

	/**
	 * @return $this
	 */
	Public function kill()
	{
		$this->parent_array->del($this->path());
		$this->data = array();

		return $this;
	}

	/**
	 * @return ParentArray
	 */
	Public function parent()
	{
		return $this->parent_array;
	}

	/**
	 * In ChildArray's child's parent is parent array.
	 * @return $this
	 */
	Public function childParent()
	{
		return $this->parent_array;
	}

}
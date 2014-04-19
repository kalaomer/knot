<?php

namespace Knot;

class ChildArray extends ParentArray {

	/**
	 * @return void
	 */
	Public function kill()
	{
		$this->parent_array->del($this->path());
		$this->data = [];
	}

}
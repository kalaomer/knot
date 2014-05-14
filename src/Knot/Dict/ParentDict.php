<?php

namespace Knot\Dict;

class ParentDict extends AbstractBody {

	public function kill()
	{
		$this->data = array();
		return $this;
	}

	public function childParent()
	{
		return $this;
	}
}
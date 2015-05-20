<?php namespace Knot\Dict;

class ParentDict extends AbstractBody {

	public function kill()
	{
		$this->data = [ ];

		return $this;
	}


	public function childParent()
	{
		return $this;
	}
}
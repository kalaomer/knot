<?php namespace Knot\Dict;

class ParentDict extends DictBody {

	public function kill()
	{
		$this->data = [ ];

		return $this;
	}

}
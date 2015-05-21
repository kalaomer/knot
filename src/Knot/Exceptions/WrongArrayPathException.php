<?php namespace Knot\Exceptions;

class WrongArrayPathException extends \Exception {

	public function __toString()
	{
		return __CLASS__ . ":[" . $this->code . "]: Wrong Path. Path: " . $this->message . '\n';
	}
}
<?php namespace Knot\Exceptions;

use Exception;

class FunctionExecuteException extends Exception {

	public function __toString()
	{
		return __CLASS__ . ":[" . $this->code . "]: Function execute error. Function: " . $this->message . '\n';
	}
}
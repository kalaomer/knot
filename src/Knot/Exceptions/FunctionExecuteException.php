<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 02.05.2015
 * Time: 22:00
 */

namespace Knot\Exceptions;

use Exception;

class FunctionExecuteException extends Exception {

	public function __toString()
	{
		return __CLASS__ . ":[" . $this->code . "]: Function execute error. Function: " . $this->message . '\n';
	}
}
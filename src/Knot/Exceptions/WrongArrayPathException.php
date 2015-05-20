<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/17/14
 * Time: 2:07 PM
 */

namespace Knot\Exceptions;

class WrongArrayPathException extends \Exception {

	public function __toString()
	{
		return __CLASS__ . ":[" . $this->code . "]: Wrong Path. Path: " . $this->message . '\n';
	}
}
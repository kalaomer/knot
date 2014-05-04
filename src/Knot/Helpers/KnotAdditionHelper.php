<?php

namespace Knot\Helpers;

use \Knot\ChildArray;
use \Knot\Exceptions\WrongArrayPathException;

/*
 * This helper method's returns changed data.
 */
Class KnotAdditionHelper implements Helper {

	Private $ready = False;

	Public $functions = array(
		"add",
		"addTo",
		"first",
		"last"
	);

	Public function __construct()
	{
		$this->ready = True;
	}

	Public function run($functionName, $arguments, $knot)
	{
		array_unshift($arguments, $knot);
		return call_user_func_array(array($this, $functionName), $arguments);
	}

	Public function isFunction($functionName)
	{
		return in_array($functionName, $this->functions);
	}

	Public function isReady()
	{
		return  $this->ready;
	}

	Public function add($knot, $someArray)
	{
		
	}

	Public function addTo()
	{

	}

	Public function first()
	{

	}

	Public function last()
	{
		
	}
}

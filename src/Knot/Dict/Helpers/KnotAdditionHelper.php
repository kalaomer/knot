<?php

namespace Knot\Helpers;

use \Knot\ChildArray;
use \Knot\Exceptions\WrongArrayPathException;

/*
 * This helper method's returns changed data.
 */
class KnotAdditionHelper implements HelperInterface {

	public $functions = array(
		"add",
		"addTo",
		"first",
		"last"
	);

	public function add($knot, $someVariable)
	{
		$arguments = func_get_args();

		array_shift($arguments);

		$knot->merge($arguments);

		return $knot;
	}

	public function addTo($knot, int $key, $someVariable)
	{
		$arguments = func_get_args();

		array_splice($arguments, 0, 2);

		foreach ($arguments as $key => $argument) {
			# code...
		}
	}

	public function first()
	{

	}

	public function last()
	{
		
	}
}

<?php

namespace Knot\Dict\Helpers;

use \Knot\Dict\HelperManager;

/*
 * This helper method's returns changed data.
 */
class PHPArrayEqualHelper implements HelperInterface {

	public $functions = array(
		"array_change_key_case",
		"array_chunk",
		"array_combine",
		"array_diff_assoc",
		"array_diff_key",
		"array_diff_uassoc",
		"array_diff_ukey",
		"array_diff",
		"array_fill_keys",
		"array_filter",
		"array_flip",
		"array_intersect_assoc",
		"array_intersect_key",
		"array_intersect_uassoc",
		"array_intersect_ukey",
		"array_intersect",
		"array_merge_recursive",
		"array_merge",
		"array_pad",
		"array_reverse",
		"array_slice",
		"array_udiff_assoc",
		"array_udiff_uassoc",
		"array_udiff",
		"array_uintersect_assoc",
		"array_uintersect_uassoc",
		"array_uintersect",
		"array_unique"
	);

	public function name()
	{
		return "phparrayequalhelper";
	}

	public function addRoutes(HelperManager $helperManager)
	{
		foreach ($this->functions as $functionName)
		{
			$route = $this->convertPHPFunctionToRoute($functionName);
			$closure = $this->createClosure($functionName);

			$helperManager->addRoute($route, $closure);
		}
	}

	public function createClosure($arrayMethodName)
	{
		return function($knot, $arguments) use ($arrayMethodName) {
			$data =& $knot->toArray();

			array_unshift($arguments, $data);
			$data = call_user_func_array($arrayMethodName, $arguments);

			return $knot;
		};
	}

	protected function convertPHPFunctionToRoute($phpFunctionName)
	{
		$route = ltrim($phpFunctionName, "array_");

		return preg_replace_callback(
			'/\_([a-z])/',
			function($matches) {
				return strtoupper($matches[1]);
			},
			$route
		);
	}
}
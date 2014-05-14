<?php

namespace Knot\Dict\Helpers;

use \Knot\Dict\HelperManager;

/*
 * This helper method's returns changed data.
 */
class PHPArrayChangerHelper implements HelperInterface {

	public $functions = array(
		"array_column",
		"array_count_values",
		"array_keys",
		"array_multisort",
		"array_pop",
		"array_product",
		"array_push",
		"array_rand",
		"array_reduce",
		"array_replace_recursive",
		"array_replace",
		"array_shift",
		"array_splice",
		"array_sum",
		"array_unshift",
		"array_values",
		"array_walk_recursive",
		"array_walk"
	);

	public function name()
	{
		return "phparraychangerhelper";
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
			return call_user_func_array($arrayMethodName, array_merge(array(&$data), $arguments));
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
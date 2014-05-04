<?php

namespace Knot\Helpers;

/*
 * This helper method's returns changed data.
 */
Class PHPArrayChangerHelper implements Helper {

	Private $ready = False;

	Public $array_functions = array(
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

	Public function __construct()
	{
		$this->ready = True;
	}

	Public function run($function_name, $arguments, $knot)
	{
		$data =& $knot->toArray();
		$array_method = $this->convertMethodToPHPFunctionName($function_name);
		return call_user_func_array($array_method, array_merge(array(&$data), $arguments));
	}

	Public function isFunction($function_name)
	{
		$array_method = $this->convertMethodToPHPFunctionName($function_name);

		return in_array($array_method, $this->array_functions);
	}

	Public function isReady()
	{
		return  $this->ready;
	}

	/**
	 * Return PSR-1 function name to PHP Array function name.
	 * @param $method
	 * @return string
	 */
	Protected function convertMethodToPHPFunctionName($method)
	{
		return 'array_' . preg_replace_callback(
				'/[A-Z]/',
				function($matches) {
					return '_' . strtolower($matches[0]);
				},
				$method);
	}
}
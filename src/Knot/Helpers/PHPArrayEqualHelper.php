<?php

namespace Knot\Helpers;

/*
 * This helper method's returns changed data.
 */
Class PHPArrayEqualHelper implements Helper {

	Private $ready = False;

	Public $array_functions = array(
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

	Public function __construct()
	{
		$this->ready = True;
	}

	Public function run($function_name, $arguments, $knot)
	{
		$data =& $knot->toArray();
		$array_method = $this->convertMethodToPHPFunctionName($function_name);

		array_unshift($arguments, $data);
		$data = call_user_func_array($array_method, $arguments);

		return $knot;
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
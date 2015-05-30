<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 31.05.2015
 * Time: 01:16
 */

namespace Knot\Dict\Helpers;

abstract class AbstractPHPArrayHelper {

	protected function convertPHPFunctionToRoute($phpFunctionName)
	{
		$route = ltrim($phpFunctionName, "array_");

		return preg_replace_callback('/\_([a-z])/', function ($matches)
		{
			return strtoupper($matches[1]);
		}, $route);
	}


	protected static function convertRouteToPHPFunction($route)
	{
		$right_side = preg_replace_callback('/([A-Z])/', function ($matches)
		{
			return '_' . strtolower($matches[1]);
		}, $route);

		return 'array_' . $right_side;
	}

}
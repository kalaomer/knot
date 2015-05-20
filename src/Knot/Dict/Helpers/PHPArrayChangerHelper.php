<?php namespace Knot\Dict\Helpers;

use Knot\Dict;
use \Knot\Dict\HelperManager;

/*
 * This helper method's returns changed data.
 */

class PHPArrayChangerHelper implements HelperInterface {

	public $functions = [
		"array_multisort",
		"array_pop",
		"array_product",
		"array_push",
		"array_rand",
		"array_reduce",
		"array_shift",
		"array_splice",
		"array_sum",
		"array_unshift",
		"array_walk_recursive",
		"array_walk"
	];


	public function getName()
	{
		return "phparraychangerhelper";
	}


	public function addRoutes(HelperManager $helperManager)
	{
		foreach ($this->functions as $functionName)
		{
			$route = $this->convertPHPFunctionToRoute($functionName);
			$helperManager->addRoute($route, [ __CLASS__, "execute" ]);
		}
	}


	public static function execute(Dict $knot, $arguments, $methodName)
	{
		$methodName = self::convertRouteToPHPFunction($methodName);
		$data       =& $knot->toArray();

		return call_user_func_array($methodName, array_merge([ &$data ], $arguments));
	}


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
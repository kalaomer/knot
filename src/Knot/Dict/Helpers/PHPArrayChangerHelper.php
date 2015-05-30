<?php namespace Knot\Dict\Helpers;

use Knot\Dict\DictBody;
use Knot\Dict\HelperManager;

/*
 * This helper method's returns changed data.
 */

class PHPArrayChangerHelper extends AbstractPHPArrayHelper implements HelperInterface {

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


	public static function execute(DictBody $knot, $arguments, $methodName)
	{
		$methodName = self::convertRouteToPHPFunction($methodName);
		$data       =& $knot->toArray();

		return call_user_func_array($methodName, array_merge([ &$data ], $arguments));
	}
}
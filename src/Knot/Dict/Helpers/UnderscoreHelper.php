<?php namespace Knot\Dict\Helpers;

use Knot\Dict;
use Knot\Dict\HelperManager;

class UnderscoreHelper implements HelperInterface {

	public $ready = false;

	public $functions = [
		"each",
		"map",
		"reduce",
		"reduceRight",
		"find",
		"filter",
		"reject",
		"all",
		"any",
		"includ",
		"invoke",
		"pluck",
		"max",
		"min",
		"groupBy",
		"sortBy",
		"sortedIndex",
		"shuffle",
		"toArray",
		"size",
		"first",
		"initial",
		"rest",
		"last",
		"compact",
		"flatten",
		"without",
		"uniq",
		"union",
		"intersection",
		"difference",
		"zip",
		"indexOf",
		"lastIndexOf",
		"range",
		"memoize",
		"throttle",
		"once",
		"after",
		"wrap",
		"compose",
		"keys",
		"values",
		"functions",
		"extend",
		"defaults",
		"clon",
		"tap",
		"has",
		"isEqual",
		"isEmpty",
		"isObject",
		"isArray",
		"isFunction",
		"isString",
		"isNumber",
		"isBoolean",
		"isDate",
		"isNaN",
		"isNull",
		"identity",
		"times",
		"mixin",
		"uniqueId",
		"escape",
		"template",
		"chain",
		"value"
	];


	public function __construct()
	{
		if ( class_exists("__") )
		{
			$this->ready = true;
		}
	}


	public function getName()
	{
		return 'underscore';
	}


	public function addRoutes(HelperManager $helperManager)
	{
		// If underscore is not exists, don't add any routes to helper.
		if ( $this->ready === true )
		{
			foreach ($this->functions as $functionName)
			{
				$helperManager->addRoute($functionName, [ __CLASS__, "execute" ]);
			}
		}
	}


	public static function execute(Dict $knot, $arguments, $functionName)
	{
		$data = $knot->toArray();

		$underscoreObject = \__($data);
		$targetFunction   = [ $underscoreObject, $functionName ];

		return call_user_func_array($targetFunction, $arguments);
	}

}

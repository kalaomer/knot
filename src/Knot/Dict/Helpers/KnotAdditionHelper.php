<?php namespace Knot\Helpers;

use \Knot\Dict\AbstractBody as Knot;
use Knot\Dict\HelperManager;
use Knot\Dict\Helpers\HelperInterface;

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


	public function getName()
	{
		return 'knotAdditionHelper';
	}


	public function addRoutes(HelperManager $helperManager)
	{

	}


	public function add(Knot $knot, $someVariable)
	{
		$arguments = func_get_args();

		array_shift($arguments);

		$knot->merge($arguments);

		return $knot;
	}


	public function addTo($knot, $key, $someVariable)
	{
		$arguments = func_get_args();

		array_splice($arguments, 0, 2);

		foreach ($arguments as $key => $argument)
		{
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

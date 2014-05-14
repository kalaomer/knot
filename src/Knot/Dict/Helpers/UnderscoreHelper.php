<?php
/**
 * Underscore.php helper.
 */

namespace Knot\Helpers;


class UnderscoreHelper implements HelperInterface {
	
	public function __construct()
	{
		if(class_exists("__"))
		{
			$this->ready = true;
		}
	}

	public function name()
	{
		return 'underscore';
	}

	public function addRoutes(HelperManager $helperManager)
	{

	}
}

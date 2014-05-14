<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/19/14
 * Time: 2:54 AM
 */

namespace Knot\Dict\Helpers;

use \Knot\Dict\HelperManager;

interface HelperInterface {

	/**
	 * Helper code name.
	 * @return string
	 */
	public function name();

	/**
	 * Load Function Routes!
	 * @param HelperManager $helperManager
	 * @return void
	 */
	public function addRoutes(HelperManager $helperManager);
}

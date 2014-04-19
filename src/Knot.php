<?php

class Knot {
	/**
	 * Version
	 */
	CONST VERSION = "1.0.0";

	/**
	 * For parsing array path.
	 */
	CONST ARRAY_PATH_DELIMITER = ".";

	/**
	 * Helpers.
	 * @var array
	 */
	Public static $helpers = array(
		"UnderscoreHelper"
	);

	/**
	 * Helper Manager.
	 * @var \Knot\HelperManager
	 */
	Public static $helper_manager;

	Public static  function init()
	{
		self::$helper_manager = new Knot\HelperManager();
	}

	Public static function create_by_reference(&$data)
	{
		return new \Knot\ParentArray($data, null, '');
	}

	Public static function create($data)
	{
		return new \Knot\ParentArray($data, null, '');
	}
}

Knot::init();
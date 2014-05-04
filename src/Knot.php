<?php
/**
 * Knot module.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Knot
 * @author   Ömer Kala <kalaomer@hotmail.com>
 * @license  https://raw.githubusercontent.com/kalaomer/knot/master/LICENSE.txt MIT licence
 * @version  GIT: $Id https://github.com/kalaomer/knot/
 * @link     https://github.com/kalaomer/knot/
 */

/**
 * Knot class.
 *
 * @category PHP
 * @package  Knot
 * @author   Ömer Kala <kalaomer@hotmail.com>
 * @license  Release: Git
 * @link     https://github.com/kalaomer/knot/
 */
class Knot
{
	/**
	 * Version
	 */
	const VERSION = "1.1";

	/**
	 * For parsing array path.
	 */
	const ARRAY_PATH_DELIMITER = ".";

	/**
	 * Helper list.
	 * @var array
	 */
	public static $helpers = array(
		"KnotPathHelper",
		"KnotAdditionHelper",
		"PHPArrayEqualHelper",
		"PHPArrayChangerHelper",
		"UnderscoreHelper"
	);

	/**
	 * Helper Manager.
	 * @var \Knot\HelperManager
	 */
	public static $helper_manager;

	/**
	 * Load Helper Manager.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public static function init()
	{
		self::$helper_manager = new Knot\HelperManager();
	}

	/**
	 * Create Knot by reference.
	 *
	 * @param array &$data Knot data
	 *
	 * @return \Knot\ParentArray
	 */
	public static function createByReference(array &$data)
	{
		return new \Knot\ParentArray($data, null, '');
	}

	/**
	 * Create Knot without reference.
	 *
	 * @param array $data Knot data
	 *
	 * @return \Knot\ParentArray
	 */
	public static function create($data)
	{
		return new \Knot\ParentArray($data, null, '');
	}
}

Knot::init();

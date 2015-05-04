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
 * @link     https://kalaomer.github.com/knot/
 */

namespace Knot\Dict;


class Dict
{
	/**
	 * Version
	 */
	const VERSION = "1.2";

	/**
	 * Create Knot by reference.
	 *
	 * @param array &$data Knot data
	 *
	 * @return \Knot\Dict\ParentDict
	 */
	public static function createByReference(array &$data)
	{
		return new ParentDict($data, null, '');
	}

	/**
	 * Create Knot without reference.
	 *
	 * @param array $data Knot data
	 *
	 * @return \Knot\Dict\ParentDict
	 */
	public static function create($data)
	{
		return new ParentDict($data, null, '');
	}
}

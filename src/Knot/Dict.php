<?php namespace Knot;

/**
 * Knot module.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Knot
 * @author   Ömer Kala <kalaomer@hotmail.com>
 * @license  https://raw.githubusercontent.com/kalaomer/knot/master/LICENSE.txt MIT licence
 * @version  GIT: https://github.com/kalaomer/knot/
 * @link     https://kalaomer.github.com/knot/
 */

use Knot\Dict\AbstractDictBody;
use Knot\Dict\ParentDict;

abstract class Dict extends AbstractDictBody {

	/**
	 * Create Knot by reference.
	 *
	 * @param array &$data Knot data
	 *
	 * @return \Knot\Dict\ParentDict
	 */
	public static function createByReference(array &$data)
	{
		return new ParentDict($data);
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
		return new ParentDict($data);
	}
}

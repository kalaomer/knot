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
 * Essential EasyArray function.
 *
 * @return \Knot\Dict\ParentDict
 */
function ar()
{
	return Knot\Dict\Dict::create(func_get_args(), null, '');
}

/**
 * Essential EasyArray function.
 *
 * @param array $array Knot data.
 *
 * @return \Knot\Dict\ParentDict
 */
function arr(array $array)
{
	return Knot\Dict\Dict::create($array, null, '');
}

/**
 * Essential EasyArray function.
 *
 * @param array &$array Knot data.
 *
 * @return \Knot\Dict\ParentDict
 */
function arrRef(&$array)
{
	return Knot\Dict\Dict::createByReference($array, null, '');
}

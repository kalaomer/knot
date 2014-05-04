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
 * @return \Knot\ParentArray
 */
function ar()
{
	return Knot::create(func_get_args(), null, '');
}

/**
 * Essential EasyArray function.
 *
 * @param array $array Knot data.
 *
 * @return \Knot\ParentArray
 */
function arr(array $array)
{
	return Knot::create($array, null, '');
}

/**
 * Essential EasyArray function.
 *
 * @param array &$array Knot data.
 *
 * @return \Knot\ParentArray
 */
function arrRef(&$array)
{
	return Knot::createByReference($array, null, '');
}

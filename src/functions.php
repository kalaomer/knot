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
	return Knot\Dict::create(func_get_args());
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
	return Knot\Dict::create($array);
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
	return Knot\Dict::createByReference($array);
}

/**
 * @param mixed $instance
 *
 * @return bool
 */
function is_dict($instance)
{
	return $instance instanceof \Knot\Dict;
}

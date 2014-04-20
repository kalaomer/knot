<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/19/14
 * Time: 2:55 AM
 */

/**
 * Essential EasyArray function.
 * @return \Knot\ParentArray
 */
function ar()
{
	return Knot::create(func_get_args(), null, '');
}

function arr(array $array)
{
	return Knot::create($array, null, '');
}

function arr_ref(&$array)
{
	return Knot::createByReference($array, null, '');
}
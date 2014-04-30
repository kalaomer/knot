<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/19/14
 * Time: 2:54 AM
 */

namespace Knot\Helpers;


interface Helper {


	/**
	 * Run function anr return result!
	 *
	 * @param $function_name string
	 * @param $data array
	 * @param $arguments array
	 * @param $knot \Knot\ParentArray
	 * @return mixed
	 */
	Public function run($function_name, $arguments, $knot);

	/**
	 * Is this function?
	 *
	 * @param $function_name string
	 * @return bool
	 */
	Public function isFunction($function_name);

	/**
	 * Helper is ready?
	 *
	 * @return bool
	 */
	Public function isReady();
} 
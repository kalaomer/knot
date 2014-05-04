<?php

namespace Knot\Helpers;

use \Knot\ChildArray;
use \Knot\Exceptions\WrongArrayPathException;

/*
 * This helper method's returns changed data.
 */
Class KnotPathHelper implements Helper {

	Private $ready = False;

	Public $functions = array(
		"get",
		"set",
		"del",
		"getOnly",
		"isPath"
	);

	Public function __construct()
	{
		$this->ready = True;
	}

	Public function run($functionName, $arguments, $knot)
	{
		array_unshift($arguments, $knot);
		return call_user_func_array(array($this, $functionName), $arguments);
	}

	Public function isFunction($functionName)
	{
		return in_array($functionName, $this->functions);
	}

	Public function isReady()
	{
		return  $this->ready;
	}

	/**
	 * @param $path
	 * @return bool
	 */
	Public function isPath($knot, $path)
	{
		try	{
			$knot->get($path);
			return true;
		}
		catch(WrongArrayPathException $e) {
			return false;
		}
	}

	Public function get($knot, $path)
	{
		$arguments = func_get_args();

		isset($arguments[2]) && $default_return = $arguments[2];

		$target_data = &$knot->toArray();

		foreach ($knot::pathParser($path) as $way) {

			if (!isset($target_data[$way]))	{

				if ( isset($default_return) ) {
					$r = $knot->set($path, $default_return);
					return $r;
				}

				throw new WrongArrayPathException($path);
			}

			$target_data = &$target_data[$way];
		}

		if (is_array($target_data))	{
			return new ChildArray($target_data, $knot->childParent(), $path);
		}

		return $target_data;
	}

	/**
	 * For Get path without parsing default return to data.
	 *
	 * @param $path
	 * @return Mixed
	 * @throws Exceptions\WrongArrayPathException
	 */
	Public function getOnly($knot, $path)
	{
		$arguments = func_get_args();

		isset($arguments[2]) && $default_return = $arguments[2];

		try	{
			return $knot->get($path);
		}
		catch(WrongArrayPathException $e) {
			if (isset($default_return)) {
				return $default_return;
			}

			throw $e;
		}
	}

	/**
	 * @param $rawPath
	 * @param $value
	 * @return Mixed|\Knot\ChildArray
	 */
	Public function set($knot, $rawPath, $value)
	{
		$target_data =& $knot->toArray();

		foreach ($knot::pathParser($rawPath) as $path) {
			// Eğer yol yok ise veya yol var ama array değilse!
			if (!isset($target_data[$path]) || !is_array($target_data[$path])) {
				$target_data[$path] = array();
			}

			$target_data =& $target_data[$path];
		}

		$target_data = $value;

		if (is_array($target_data)) {
			return new ChildArray($target_data, $knot->childParent(), $knot->path());
		}

		return $value;
	}

	/**
	 * @param $rawPath
	 * @return $this
	 */
	Public function del($knot, $rawPath)
	{
		$target_data =& $knot->toArray();

		$paths = $knot::pathParser($rawPath);

		$target_key = array_pop($paths);

		foreach ($paths as $path) {
			// Eğer yol yok ise veya yol var ama array değilse!
			if (!isset($target_data[$path]) || !is_array($target_data[$path])) {
				return $knot;
			}

			$target_data =& $target_data[$path];
		}

		if (isset($target_data[$target_key])) {
			unset($target_data[$target_key]);
		}

		return $knot;
	}
}
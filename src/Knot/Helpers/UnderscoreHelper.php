<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/19/14
 * Time: 2:22 PM
 */

namespace Knot\Helpers;


class UnderscoreHelper implements Helper {

	Private $ready = false;

	Public function __construct()
	{
		if(class_exists("__"))
		{
			$this->ready = true;
		}
	}

	Public function is_ready()
	{
		return $this->ready;
	}

	Public function run($function_name, $data, $arguments)
	{
		$underscore = \__($data);

		return call_user_func_array(array($underscore, $function_name), $arguments);
	}

	Public function is_function($function_name)
	{
		if(method_exists("__", $function_name))
		{
			return true;
		}

		return false;
	}

} 
<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/19/14
 * Time: 2:30 PM
 */

namespace Knot;


class HelperManager {

	Private $helpers = array();

	Public function __construct()
	{
		$this->loadHelpers(\Knot::$helpers);
	}

	Public function loadHelpers($helper_list)
	{
		foreach($helper_list as $helper_name)
		{
			if(!$this->isHelper($helper_name))
			{
				$helper_address = 'Knot\\Helpers\\' . $helper_name;
				$this->helpers[$helper_name] = new $helper_address;
			}
		}
	}

	Public function execute($function_name, $data, $arguments)
	{
		$target_helper = $this->isFunction($function_name);

		if($target_helper == false)
		{
			throw new \Exception("Wrong function name! Function: " . $function_name);
		}

		return $target_helper->run($function_name, $data, $arguments);
	}

	Public function isFunction($function_name)
	{
		foreach($this->helpers as $helper)
		{
			if ($helper->isFunction($function_name))
			{
				return $helper;
			}
		}

		return false;
	}

	Public function isHelper($helper_name)
	{
		return isset($this->helpers[$helper_name]);
	}
} 
<?php

namespace Knot;

use \Knot\Exceptions\WrongFunctionException;

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

	Public function execute($function_name, $arguments, $knot)
	{
		$target_helper = $this->targetHelper($function_name);

		if($target_helper == false)
		{
			throw new WrongFunctionException("Wrong function name! Function: " . $function_name);
		}

		try {
			return $target_helper->run($function_name, $arguments, $knot);
		}
		catch(\Exception $e)
		{
			throw $e;
		}
	}

	Public function targetHelper($function_name)
	{
		foreach($this->helpers as $helper)
		{
			if ($helper->isReady() && $helper->isFunction($function_name) !== False)
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
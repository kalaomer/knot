<?php

class PHPArrayExceptionTest extends PHPUnit_Framework_TestCase {

	Protected $objArray = array(
		1,2,3,
		"foo" => array(
			"sub" => array(
				"vuu" => "uuuuvvv"
			),
			"another" => "pff"
		),
		"my" => array(
			"name", "is", "Knot!"
		),
		"string" => "info.."
	);
	
	/**
	 * @dataProvider simpleObj
	 * @expectedException \Knot\Exceptions\WrongArrayPathException
	 */
	Public function testGetManually($obj)
	{
		$obj->__get('asd');
	}

	/**
	 * @expectedException \Exception
	 */
	Public function testCallDataCallable()
	{
		$obj = ar();

		$obj->function = function($a, $b) {};

		$obj->function();
	}

	/**
	 * @expectedException \Knot\Exceptions\WrongFunctionException
	 */
	Public function testFunction()
	{
		$obj = ar();

		$obj->noway();
	}

	/**
	 * @expectedException \Exception
	 */
	Public function testHelperFunction()
	{
		$obj = ar();

		$obj->merge(1,2,3);
	}

	Public function simpleObj()
	{
		return array(
			array(arr($this->objArray))
		);
	}
}